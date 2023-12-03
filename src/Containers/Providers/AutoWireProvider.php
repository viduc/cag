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

use Cag\Spec\Mock\ClassForProvider\WithSimpleClassParam;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Cag\Containers\Aggregates\DefinitionParameterAggregate;
use Cag\Containers\Aggregates\DefinitionsAggregate;
use Cag\Containers\Aggregates\ParameterAggregate;
use Cag\Containers\ClassSearchAbstract;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\DefinitionParameter;
use Cag\Containers\Models\Parameter;
use Cag\Containers\Validators\AutoWireValidatorAbstract;

class AutoWireProvider implements ProviderInterface
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
     * @param string $class
     *
     * @return bool
     */
    public function provides(string $class): bool
    {
        try {
            $reflection = new ReflectionClass($class);
            return AutoWireValidatorAbstract::validInstantiable($reflection);
        } catch (ReflectionException) {
            return false;
        }
    }

    /**
     * @return void
     * @throws DefinitionException
     * @throws ReflectionException
     */
    public function register(): void
    {
        $this->aggregate = new DefinitionsAggregate();
        $this->definitionParameterAggregate = new DefinitionParameterAggregate();
        $this->parameterAggregate = new ParameterAggregate();
        foreach (ClassSearchAbstract::getAllClass() as $class) {
            if ($this->provides($class->class)) {
                $this->addDefinition($class->class);
            }
        }
    }

    /**
     * @param string $name
     *
     * @throws DefinitionException
     * @throws ReflectionException
     */
    private function addDefinition(string $name): void
    {
        if (!$this->aggregate->has($name)) {
            $definition = new Definition($name, $name);
            $this->aggregate->add($definition);
            $this->addParam($definition);
        }
    }

    /**
     * @param Definition $definition
     *
     * @throws ReflectionException
     * @throws DefinitionException
     */
    private function addParam(Definition $definition): void
    {
        $reflection = new ReflectionClass($definition->class);

        if (!is_null($reflection->getConstructor()) &&
            AutoWireValidatorAbstract::validParams($reflection)) {
            foreach ($reflection->getConstructor()->getParameters() as $param) {
                $this->saveParam($definition, $param);
            }
        }
    }

    /**
     * @param Definition          $definition
     * @param ReflectionParameter $param
     *
     * @return void
     * @throws DefinitionException
     * @throws ReflectionException
     */
    private function saveParam(
        Definition $definition,
        ReflectionParameter $param
    ): void {
        if (!is_null($param->getType()) && !$param->isOptional()) {
            $class = $param->getType()->getName();
            $parameter = new Parameter('%'.$class.'%', $param->getName());
            $implementations = ClassSearchAbstract::getInterfaceImplementations(
                $class
            );
            $class = count($implementations) === 1 ? $implementations[0]->class:
                $class;
            if ($this->provides($class)) {
                $parameter = new Parameter(
                    $this->getDefinition($class),
                    $param->getName(),
                    true
                );
            }

            $this->parameterAggregate->add($parameter);
            $this->definitionParameterAggregate->add(
                new DefinitionParameter(
                    $definition->name,
                    $parameter->id
                )
            );
        }
    }

    /**
     * @param string $class
     *
     * @return Definition
     * @throws DefinitionException
     * @throws ReflectionException
     */
    public function getDefinition(string $class): Definition
    {
        if (!$this->aggregate->has($class)) {
            $definition = new Definition($class);
            $this->aggregate->add($definition);
            $this->addParam($definition);
        }
        return $this->aggregate->get($class);
    }

    /**
     * @return DefinitionsAggregate
     */
    public function getAggregate(): DefinitionsAggregate
    {
        return $this->aggregate;
    }
}
