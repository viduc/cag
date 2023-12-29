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
use Cag\Containers\ClassSearchAbstract;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\DefinitionParameter;
use Cag\Containers\Models\Parameter;
use Cag\Containers\Validators\AutoWireValidatorAbstract;

class AutoWireProvider implements ProviderInterface
{
    public DefinitionsAggregate $aggregate;

    public DefinitionParameterAggregate $definitionParameterAggregate;

    public ParameterAggregate $parameterAggregate;

    public function provides(string $class): bool
    {
        try {
            $reflection = new \ReflectionClass(objectOrClass: $class);

            return AutoWireValidatorAbstract::validInstantiable(
                reflection: $reflection
            );
        } catch (\ReflectionException) {
            return false;
        }
    }

    /**
     * @throws \ReflectionException|ComposerException|DefinitionException
     */
    public function register(): void
    {
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
        foreach (ClassSearchAbstract::getAllClass() as $class) {
            if ($this->provides(class: $class->class)) {
                $this->addDefinition(name: $class->class);
            }
        }
    }

    /**
     * @throws \ReflectionException|ComposerException|DefinitionException
     */
    private function addDefinition(string $name): void
    {
        if (!$this->aggregate->has(param: $name)) {
            $definition = new Definition(class: $name, name: $name);
            $this->aggregate->add(param: $definition);
            $this->addParam(definition: $definition);
        }
    }

    /**
     * @throws DefinitionException|ComposerException|\ReflectionException
     */
    private function addParam(Definition $definition): void
    {
        $reflection = new \ReflectionClass(objectOrClass: $definition->class);
        if (!is_null(value: $reflection->getConstructor())
            && AutoWireValidatorAbstract::validParams(reflection: $reflection)) {
            foreach ($reflection->getConstructor()->getParameters() as $param) {
                $this->saveParam(definition: $definition, param: $param);
            }
        }
    }

    /**
     * @throws DefinitionException
     * @throws \ReflectionException|ComposerException
     */
    private function saveParam(
        Definition $definition,
        \ReflectionParameter $param
    ): void {
        if (!is_null(value: $param->getType()) && !$param->isOptional()) {
            $class = $param->getType()->getName();
            $parameter = new Parameter(
                value: '%'.$class.'%',
                name: $param->getName()
            );
            $implementations = ClassSearchAbstract::getInterfaceImplementations(
                interface: $class
            );
            $class = 1 === count(value: $implementations)
                ? $implementations[0]->class : $class;
            if ($this->provides(class: $class)) {
                $parameter = new Parameter(
                    value: $this->getDefinition(class: $class),
                    name: $param->getName(),
                    isDefinition: true
                );
            }
            $this->parameterAggregate->add(param: $parameter);
            $this->definitionParameterAggregate->add(
                param: new DefinitionParameter(
                    definition_id: $definition->name,
                    parameter_id: $parameter->id
                )
            );
        }
    }

    /**
     * @throws DefinitionException
     * @throws \ReflectionException
     */
    public function getDefinition(string $class): Definition
    {
        if (!$this->aggregate->has(param: $class)) {
            $definition = new Definition(class: $class);
            $this->aggregate->add(param: $definition);
            $this->addParam(definition: $definition);
        }

        return $this->aggregate->get(param: $class);
    }

    public function getAggregate(): DefinitionsAggregate
    {
        return $this->aggregate;
    }
}
