<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Spec\Implentation\Containers;

use Cag\Containers\ContainerInterface;
use Cag\Exceptions\NotFoundException;
use ReflectionClass;
use Spec\Implentation\Loggers\Logger;

class Container implements ContainerInterface
{
    /**
     * @throws \ReflectionException
     * @throws NotFoundException
     */
    public function get(string $id): mixed
    {
        $reflection = new ReflectionClass($id);
        if (str_contains($reflection->getName(), 'LoggerInterface')) {
            return new Logger();
        }
        throw new NotFoundException(
            "No entry found for ".$id." indentifier"
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function has(string $id): bool
    {
        $reflection = new ReflectionClass($id);
        if (str_contains($reflection->getName(), 'LoggerInterface')) {
            return true;
        }
        return isset($this->$id);
    }
}
