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

class FileSystemModel extends ModelAbstract
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
     * @var FolderModel|null
     */
    public ?FolderModel $parent = null;

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
     * @return FolderModel|null
     */
    public function getParent(): ?FolderModel
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

    /**
     * @param ModelAbstract $model
     *
     * @return bool
     */
    public function isEqual(ModelAbstract $model): bool
    {
        if ($this->getName() !== $model->getName()) {
            return false;
        }
        if (null === $this->getParent() && null === $model->getParent()) {
            return true;
        }
        if (null !== $this->getParent() && null !== $model->getParent() &&
            $this->getParent()->getName()
            === $model->getParent()->getName()) {
            return true;
        }

        return false;
    }
}
