<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Providers;

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
    public array $list;

    public DefinitionsAggregate $aggregate;

    public DefinitionParameterAggregate $definitionParameterAggregate;

    public ParameterAggregate $parameterAggregate;

    public function __construct(string $path = null)
    {
        if (is_null(value: $path)) {
            $path = str_replace(
                search: 'Containers'.DIRECTORY_SEPARATOR.'Providers',
                replace: 'Config',
                subject: __DIR__
            );
            $path .= '/container.yml';
        }
        $this->list = yaml_parse_file(filename: $path)['services'];
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
    }

    public function provides(string $id): bool
    {
        foreach (array_keys(array: $this->list) as $name) {
            if (strtolower(string: $id) === strtolower(string: $name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws DefinitionException|NotFoundException
     */
    public function register(): void
    {
        foreach ($this->list as $name => $service) {
            try {
                $reflection = new \ReflectionClass(objectOrClass: $name);
                if ($reflection->isInstantiable()) {
                    $this->addDefinition(name: $name, service: $service);
                }
            } catch (\ReflectionException) {
                throw new DefinitionException(message: sprintf(DefinitionException::LOG_NOT_FOUND, 'class', $name), code: DefinitionException::CODE_NOT_FOUND);
            }
        }
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     */
    private function addDefinition(
        string $name,
        array $service
    ): void {
        if (!$this->aggregate->has(param: $name)) {
            $definition = new Definition(class: $name, name: $name);
            $this->aggregate->add(param: $definition);
            $this->addParam(definition: $definition, service: $service);
        }
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     */
    private function addParam(Definition $definition, array $service): void
    {
        if (!isset($service['params']) || !is_array(value: $service['params'])) {
            return;
        }
        $params = $service['params'];
        array_walk(
            array: $params,
            callback: function ($param) use ($definition) {
                $name = array_key_first(array: $param);
                $value = $param[$name];
                $parameter = $this->defineParameter(name: $name, value: $value);
                $this->parameterAggregate->add(param: $parameter);
                $this->definitionParameterAggregate->add(
                    param: new DefinitionParameter(
                        definition_id: $definition->name,
                        parameter_id: $parameter->id
                    )
                );
            }
        );
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     */
    private function defineParameter(string $name, string $value): Parameter
    {
        $parameter = new Parameter(value: $value, name: $name);
        try {
            $reflection = new \ReflectionClass(objectOrClass: $value);
            if ($reflection->isInstantiable()) {
                $parameter = new Parameter(value: '%'.$value.'%', name: $name);
                if ($this->provides(id: $value)) {
                    $parameter = new Parameter(
                        value: $this->getDefinition($value),
                        name: $name,
                        isDefinition: true
                    );
                }
            }
        } catch (\ReflectionException) {
        }

        return $parameter;
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     */
    public function getDefinition(string $name): Definition
    {
        $this->addDefinition(name: $name, service: $this->list[$name]);

        return $this->aggregate->get(param: $name);
    }

    public function getAggregate(): DefinitionsAggregate
    {
        return $this->aggregate;
    }
}
