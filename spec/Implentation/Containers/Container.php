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

class Container implements ContainerInterface
{
    public function get(string $id): mixed
    {
        throw new NotFoundException(
            "No entry found for ".$id." indenntifier"
        );
    }

    public function has(string $id): bool
    {
        return isset($this->$id);
    }

    private function instancierService(string $service): void
    {
    }
}
