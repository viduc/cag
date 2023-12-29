<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

class StructureModel extends ModelAbstract
{
    public const DS = DIRECTORY_SEPARATOR;

    /**
     * Nom du dossier src.
     */
    public string $srcName;

    public string $path;

    public function __construct(string $srcName, string $path = 'src')
    {
        $this->srcName = $srcName;
        $this->path = $path;
        $this->formatPath();
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    private function formatPath(): void
    {
        $this->path = rtrim(
            string: ltrim(
                string: str_replace(
                    search: ['/', '\\'],
                    replace: self::DS,
                    subject: $this->path
                ),
                characters: self::DS
            ),
            characters: self::DS
        );
    }
}
