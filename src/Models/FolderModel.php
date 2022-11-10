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

class FolderModel extends ModelAbstract
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @var string
     */
    public string $name;

    /**
     * @var FolderModel
     */
    public FolderModel $parent;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return FolderModel
     */
    public function getParent(): FolderModel
    {
        return $this->parent;
    }

    /**
     * @param FolderModel $parent
     */
    public function setParent(FolderModel $parent): void
    {
        $this->parent = $parent;
    }

}
