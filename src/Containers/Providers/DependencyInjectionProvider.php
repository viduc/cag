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

use ReflectionException;
use Cag\Containers\Aggregates\AggregateInterface;
use Cag\Containers\Aggregates\DefinitionParameterAggregate;
use Cag\Containers\Aggregates\DefinitionsAggregate;
use Cag\Containers\Aggregates\ParameterAggregate;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\Parameter;

class DependencyInjectionProvider implements ProviderInterface
{
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
     * @var AutoWireProvider
     */
    private AutoWireProvider $autowire;

    /**
     * @var ConfigWireProvider
     */
    private ConfigWireProvider $config;

    /**
     * @var ExternalWireProvider|null
     */
    private ?ExternalWireProvider $external = null;

    /**
     * @param string|null                       $path
     *
     * @throws ComposerException
     * @throws DefinitionException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function __construct(?string $path = null)
    {
        $this->config = new ConfigWireProvider($path);
        $this->autowire = new AutoWireProvider();
        $this->external = new ExternalWireProvider();
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
        $this->register();
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool
    {
        return $this->aggregate->has($id);
    }

    /**
     * @return void
     * @throws DefinitionException
     * @throws NotFoundException
     * @throws ReflectionException
     * @throws ComposerException
     */
    public function register(): void
    {
        $this->external->register();
        $this->autowire->register();
        $this->config->register();
        $this->aggregate->merge(
            $this->autowire->getAggregate()->merge(
                $this->config->getAggregate()->merge(
                    $this->external->getAggregate()
                )
            )
        );
        $this->parameterAggregate->merge(
            $this->autowire->parameterAggregate->merge(
                $this->config->parameterAggregate
            )
        );
        $this->definitionParameterAggregate->merge(
            $this->autowire->definitionParameterAggregate->merge(
                $this->config->definitionParameterAggregate
            )
        );
        $this->completeParameters();
    }

    /**
     * @return void
     */
    private function completeParameters(): void
    {
        foreach ($this->parameterAggregate->aggregates as $parameter) {
            if ($parameter->isClass()) {
                $this->parameterAggregate->aggregates[$parameter->id] =
                    $this->completeDefinitionParameters($parameter);
            }
        }
    }

    /**
     * @param Parameter $param
     * @return Parameter
     * @throws DefinitionException
     */
    private function completeDefinitionParameters(Parameter $param): Parameter
    {
        $value = str_replace('%', '', $param->value);
        if ($this->aggregate->has($value)) {
            $param->value = $this->aggregate->get($value);
            $param->type = "definition";
            $param->isDefinition = true;
        }

        return $param;
    }

    /**
     * @return AggregateInterface
     */
    public function getAggregate(): AggregateInterface
    {
        return $this->aggregate;
    }

    /**
     * @param string $id
     *
     * @return Definition
     * @throws DefinitionException
     */
    public function getDefinition(string $id): Definition
    {
        return $this->aggregate->get($id);
    }

    /**
     * @param string $id
     *
     * @return Parameter[]
     *
     * @throws DefinitionException
     */
    public function getDefinitionParameters(string $id): array
    {
        $params = [];
        foreach ($this->definitionParameterAggregate->getAllByDefinition(
            $this->getDefinition($id)
        ) as $param) {
            $params[] = $this->parameterAggregate->getById($param->parameter_id);
        }

        return $params;
    }
}
