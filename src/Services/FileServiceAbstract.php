<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Services;

abstract class FileServiceAbstract implements ServiceInterface
{
    public function __construct()
    {
    }

    /**
     * @param string $name
     * @param string $contenu
     * @return void
     */
    public abstract function create(string $name, string $contenu = ''): void;

    /**
     * @param string $name
     * @param string $contenu
     * @param bool $append
     * @return void
     */
    public abstract function update(
        string $name,
        string $contenu = '',
        bool $append = false
    ): void;

    /**
     * @param string $name
     * @return bool
     */
    public abstract function delete(string $name): bool;
}
