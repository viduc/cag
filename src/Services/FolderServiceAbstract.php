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
     * @param string $source
     * @param string $target
     * @param bool $recursive
     * @return void
     */
    public abstract function copy(
        string $source,
        string $target,
        bool $recursive = true
    ): void;

    /**
     * @return string
     */
    public function getProjectPath(): string
    {
        $explode = explode(separator: 'vendor', string: self::getFullPath());

        return $explode[0];
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return __DIR__;
    }
}
