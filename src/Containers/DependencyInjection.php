<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

use ReflectionClass;
use ReflectionException;
use Cag\Containers\Aggregates\ImplementationAggregate;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Providers\DependencyInjectionProvider;

class DependencyInjection implements DependencyInjectionInterface
{
    const LOG_NOT_FOUND = 'Class %s not found';
    const LOG_NOT_FOUND_CODE = 100;

    /**
     * @var ImplementationAggregate
     */
    public ImplementationAggregate $aggregate;

    /**
     * @var DependencyInjectionInterface|null
     */
    private DependencyInjectionInterface|null $externalContainer;

    /**
     * @var DependencyInjectionProvider
     */
    private DependencyInjectionProvider $provider;

    /**
     * @param DependencyInjectionInterface|null $container
     * @param string|null                       $path
     *
     * @throws Exceptions\ComposerException
     * @throws Exceptions\DefinitionException
     * @throws Exceptions\NotFoundException
     * @throws ReflectionException
     */
    public function __construct(
        DependencyInjectionInterface|null $container = null,
        string|null $path = null
    ) {
        $this->externalContainer = $container;
        $this->provider = new DependencyInjectionProvider(path: $path);
        $this->aggregate = new ImplementationAggregate();
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws Exceptions\DefinitionException
     * @throws Exceptions\DependencyInjectionException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function get(string $id): mixed
    {
        if (!$this->has(id: $id)) {
            throw new NotFoundException(
                message: sprintf(self::LOG_NOT_FOUND, $id),
                code: self::LOG_NOT_FOUND_CODE
            );
        }

        return $this->aggregate->has(param: $id) ? $this->aggregate->get(param: $id):
            $this->instantiate(id: $id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->provider->provides(id: $id);
    }

    /**
     * @param string $id
     *
     * @return mixed
     * @throws Exceptions\DefinitionException
     * @throws Exceptions\DependencyInjectionException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    private function instantiate(string $id): mixed
    {
        $definition = $this->provider->getDefinition(id: $id);
        if ($definition->external) {
            return $this->instantiateExternal(definition: $definition);
        }
        $params = [];
        foreach ($this->provider->getDefinitionParameters(id: $id) as $parameter) {
            $params[$parameter->name] = $parameter->value;
            if ($parameter->isDefinition) {
                $params[$parameter->name] = $this->get(id: $parameter->value->class);
            }
        }
        $reflection = new ReflectionClass(objectOrClass: $definition->class);
        $instance = $reflection->newInstanceArgs(args: $params);
        $this->aggregate->add(param: $instance);

        return $instance;
    }

    /**
     * @param Definition $definition
     *
     * @return mixed
     * @throws Exceptions\DependencyInjectionException
     * @throws NotFoundException
     */
    private function instantiateExternal(Definition $definition): mixed
    {
        if ($this->externalContainer !== null &&
            $this->externalContainer->has(id: $definition->class)
        ) {
            return $this->externalContainer->get(id: $definition->class);
        }
        throw new NotFoundException(
            message: sprintf(format: self::LOG_NOT_FOUND, values: $definition->class),
            code: self::LOG_NOT_FOUND_CODE
        );
    }
}
