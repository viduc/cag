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
    public DefinitionsAggregate $aggregate;

    public DefinitionParameterAggregate $definitionParameterAggregate;

    public ParameterAggregate $parameterAggregate;

    private AutoWireProvider $autowire;

    private ConfigWireProvider $config;

    private ExternalWireProvider|null $external;

    /**
     * @throws ComposerException
     * @throws DefinitionException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function __construct(string $path = null)
    {
        $this->config = new ConfigWireProvider($path);
        $this->autowire = new AutoWireProvider();
        $this->external = new ExternalWireProvider();
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
        $this->register();
    }

    public function provides(string $id): bool
    {
        return $this->aggregate->has(param: $id);
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     * @throws \ReflectionException
     * @throws ComposerException
     */
    public function register(): void
    {
        $this->external->register();
        $this->autowire->register();
        $this->config->register();
        $this->aggregate->merge(
            $this->autowire->getAggregate()->merge(
                aggregate: $this->config->getAggregate()->merge(
                    aggregate: $this->external->getAggregate()
                )
            )
        );
        $this->parameterAggregate->merge(
            aggregate: $this->autowire->parameterAggregate->merge(
                aggregate: $this->config->parameterAggregate
            )
        );
        $this->definitionParameterAggregate->merge(
            aggregate: $this->autowire->definitionParameterAggregate->merge(
                aggregate: $this->config->definitionParameterAggregate
            )
        );
        $this->completeParameters();
    }

    /**
     * @throws DefinitionException
     */
    private function completeParameters(): void
    {
        foreach ($this->parameterAggregate->aggregates as $parameter) {
            if ($parameter->isClass()) {
                $this->parameterAggregate->aggregates[$parameter->id] =
                    $this->completeDefinitionParameters(param: $parameter);
            }
        }
    }

    /**
     * @throws DefinitionException
     */
    private function completeDefinitionParameters(Parameter $param): Parameter
    {
        $value = str_replace(search: '%', replace: '', subject: $param->value);
        if ($this->aggregate->has(param: $value)) {
            $param->value = $this->aggregate->get(param: $value);
            $param->type = 'definition';
            $param->isDefinition = true;
        }

        return $param;
    }

    public function getAggregate(): AggregateInterface
    {
        return $this->aggregate;
    }

    /**
     * @throws DefinitionException
     */
    public function getDefinition(string $id): Definition
    {
        return $this->aggregate->get(param: $id);
    }

    /**
     * @return Parameter[]
     *
     * @throws DefinitionException
     */
    public function getDefinitionParameters(string $id): array
    {
        $params = [];
        $parameters = $this->definitionParameterAggregate->getAllByDefinition(
            definition: $this->getDefinition(id: $id)
        );
        array_walk(
            array: $parameters,
            callback: function ($param) use (&$params) {
                $params[] = $this->parameterAggregate->getById(id: $param->parameter_id);
            }
        );

        return $params;
    }
}
