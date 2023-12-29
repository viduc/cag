<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Spec\Containers;

use Cag\Containers\DependencyInjectionInterface;
use Cag\Spec\Mock\ClassForProvider\Interfaces\Dependencies\ExternalDependenceInterface;
use External\ImpExternalDependenceInterface;
use ReflectionClass;
use ReflectionException;

class ExternalDependencyInjection implements DependencyInjectionInterface
{
    /**
     * @var string[]
     */
    private array $list = [
        ExternalDependenceInterface::class => ImpExternalDependenceInterface::class
    ];

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function get(string $id): mixed
    {
        $reflection = new ReflectionClass(objectOrClass: $this->list[$id]);
        return $reflection->newInstance();
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists(key: $id, array: $this->list);
    }
}
