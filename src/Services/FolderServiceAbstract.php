<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
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

    abstract public function create(string $name): void;

    abstract public function copy(
        string $source,
        string $target,
        bool $recursive = true
    ): void;

    public function getProjectPath(): string
    {
        $explode = explode(separator: 'vendor', string: self::getFullPath());

        return $explode[0];
    }

    public function getFullPath(): string
    {
        return __DIR__;
    }
}
