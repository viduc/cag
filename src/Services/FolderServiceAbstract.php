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

abstract class FolderServiceAbstract implements ServiceInterface
{
    public function __construct()
    {
    }

    /**
     * @param string $name
     * @return void
     */
    public abstract function create(string $name): void;

    /**
     * @param string $name
     * @return bool
     */
    public abstract function delete(string $name): bool;

    public abstract  function getProjectPath(): string;

    public abstract function getFullPath(): string;
}