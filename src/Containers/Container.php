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

use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $extrenalContainer;

    /**
     * @var ReflectionClass|null
     */
    private ?ReflectionClass $reflection = null;

    private array $params = [];

    public function __construct(ContainerInterface $external)
    {
        $this->extrenalContainer = $external;
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            $this->reflection = new ReflectionClass($id);
            if ($this->reflection->isInterface()) {
                return $this->extrenalContainer->get($id);
            }

            return $this->reflection->newInstanceArgs(
                $this->instantiateDependencies()
            );
        }
        throw new NotFoundException(
            "No entry was found for ".$id." identifier"
        );
    }

    /**
     * @return array
     * @throws NotFoundException
     * @throws ReflectionException
     * @throws ContainerException
     */
    private function instantiateDependencies(): array
    {
        $dependencies = [];
        if (null !== $this->reflection &&
            null !== $this->reflection->getConstructor()
        ) {
            foreach ($this->reflection->getConstructor()->getParameters()
                 as $param
            ) {
                $type = $param->getType();
                $dependencies[] = !$type->isBuiltin() ?
                    $this->get((string) $type):
                    $this->getBuiltinParameter($param->getName());
            }
        }

        return $dependencies;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    private function getBuiltinParameter(string $name): mixed
    {
        return $this->params[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        try {
            $reflection = new ReflectionClass($id);
            if ($reflection->isInterface()) {
                return $this->extrenalContainer->has($id);
            }
            return $reflection->isInstantiable();
        } catch (ReflectionException $e) {
            return $this->extrenalContainer->has($id);
        }
    }

    /**
     * @param array $params
     *
     * @return void
     */
    public function addParams(array $params): void
    {
        $this->params = array_merge($this->params, $params);
    }
}
