<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Providers;

use ReflectionClass;
use ReflectionException;
use Cag\Containers\Aggregates\DefinitionParameterAggregate;
use Cag\Containers\Aggregates\DefinitionsAggregate;
use Cag\Containers\Aggregates\ParameterAggregate;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\DefinitionParameter;
use Cag\Containers\Models\Parameter;

class ConfigWireProvider implements ProviderInterface
{
    /**
     * @var array|mixed
     */
    private array $list;

    /**
     * @var DefinitionsAggregate
     */
    public DefinitionsAggregate $aggregate;

    /**
     * @var DefinitionParameterAggregate
     */
    public DefinitionParameterAggregate $definitionParameterAggregate;

    /**
     * @var ParameterAggregate
     */
    public ParameterAggregate $parameterAggregate;

    /**
     * @param string|null $path
     */
    public function __construct(?string $path = null)
    {
        if (is_null($path)) {
            $path = str_replace(
                'Containers' . DIRECTORY_SEPARATOR . 'Providers',
                'Config',
                __DIR__
            );
            $path .= '/container.yml';
        }
        $this->list = yaml_parse_file($path)['services'];
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool
    {
        foreach (array_keys($this->list) as $name) {
            if (strtolower($id) === strtolower($name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     * @throws DefinitionException|NotFoundException
     */
    public function register(): void
    {
        foreach ($this->list as $name => $service) {
            try {
                $reflection = new ReflectionClass($name);
                if ($reflection->isInstantiable()) {
                    $this->addDefinition($name, $service);
                }
            } catch (ReflectionException $exception) {
            }
        }
    }

    /**
     * @param string $name
     * @param array  $service
     *
     * @return void
     * @throws DefinitionException
     * @throws NotFoundException
     */
    private function addDefinition(
        string $name,
        array $service
    ): void {
        if (!$this->aggregate->has($name)) {
            $definition = new Definition($name, $name);
            $this->aggregate->add($definition);
            $this->addParam($definition, $service);
        }
    }

    /**
     * @param Definition $definition
     * @param array      $service
     *
     * @return void
     * @throws DefinitionException
     * @throws NotFoundException
     */
    private function addParam(Definition $definition, array $service): void
    {
        foreach ($service['params'] as $param) {
            $name = array_key_first($param);
            $value = $param[$name];
            $parameter = new Parameter($value, $name);
            try {
                $reflection = new ReflectionClass($value);
                if ($reflection->isInstantiable()) {
                    $parameter = new Parameter('%'.$value.'%', $name);
                    if ($this->provides($value)) {
                        $parameter = new Parameter(
                            $this->getDefinition($value),
                            $name,
                            true
                        );
                    }
                }
            } catch (ReflectionException $exception) {
            }
            $this->parameterAggregate->add($parameter);
            $this->definitionParameterAggregate->add(
                new DefinitionParameter($definition->name, $parameter->id)
            );
        }
    }

    /**
     * @param string $name
     *
     * @return Definition
     * @throws DefinitionException
     * @throws NotFoundException
     */
    public function getDefinition(string $name): Definition
    {
        $this->addDefinition($name, $this->list[$name]);
        return $this->aggregate->get($name);
    }

    /**
     * @return DefinitionsAggregate
     */
    public function getAggregate(): DefinitionsAggregate
    {
        return $this->aggregate;
    }
}
