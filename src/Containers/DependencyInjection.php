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

use Cag\UseCases\CreateProjectUseCase;
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
    private ?DependencyInjectionInterface $externalContainer;

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
        ?DependencyInjectionInterface $container = null,
        ?string $path = null
    ) {
        $this->externalContainer = $container;
        $this->provider = new DependencyInjectionProvider($path);
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
        if (!$this->has($id)) {
            throw new NotFoundException(
                sprintf(self::LOG_NOT_FOUND, $id),
                self::LOG_NOT_FOUND_CODE
            );
        }

        return $this->aggregate->has($id) ? $this->aggregate->get($id):
            $this->instantiate($id);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->provider->provides($id);
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
        $definition = $this->provider->getDefinition($id);
        if ($definition->external) {
            return $this->instantiateExternal($definition);
        }
        $params = [];var_dump($id);
        foreach ($this->provider->getDefinitionParameters($id) as $parameter) {var_dump($parameter);
            $params[$parameter->name] = $parameter->value;
            if ($parameter->isDefinition) {
                $params[$parameter->name] = $this->instantiate($parameter->value);
            }
        }
        $reflection = new ReflectionClass($definition->class);
        $instance = $reflection->newInstanceArgs($params);
        $this->aggregate->add($instance);

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
            $this->externalContainer->has($definition->class)
        ) {
            return $this->externalContainer->get($definition->class);
        }
        throw new NotFoundException(
            sprintf(self::LOG_NOT_FOUND, $definition->class),
            self::LOG_NOT_FOUND_CODE
        );
    }
}
