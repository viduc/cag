<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

use Cag\Containers\Exceptions\DependencyInjectionException;
use Cag\Containers\Exceptions\NotFoundException;

interface DependencyInjectionInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id identifier of the entry to look for
     *
     * @return mixed entry
     *
     * @throws DependencyInjectionException error while retrieving the entry
     * @throws NotFoundException            no entry was found for **this** identifier
     */
    public function get(string $id): mixed;

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id identifier of the entry to look for
     */
    public function has(string $id): bool;
}
