<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

class FileModel extends FileSystemModel
{
    public string $type = '';

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return 'abstract' === strtolower($this->type);
    }

    /**
     * @return bool
     */
    public function isClass(): bool
    {
        return 'class' === strtolower($this->type);
    }

    /**
     * @return bool
     */
    public function isInterface(): bool
    {
        return 'interface' === strtolower($this->type);
    }
}
