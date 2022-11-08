<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Model;

use Cag\Exception\StructureModelException;

class StructureModel extends AbstractModel
{
    /**
     * Nom du dossier src
     * @var string
     */
    public string $srcName;

    /**
     * @var FolderModel[]
     */
    public array $folders = [];

    /**
     * @param string $srcName
     */
    public function __construct(string $srcName)
    {
        $this->srcName = $srcName;
    }

    /**
     * @return string
     */
    public function getSrcName(): string
    {
        return $this->srcName;
    }

    /**
     * @param string $srcName
     */
    public function setSrcName(string $srcName): void
    {
        $this->srcName = $srcName;
    }

    /**
     * @return array
     */
    public function getFolders(): array
    {
        return $this->folders;
    }

    /**
     * @param array $folders
     */
    public function setFolders(array $folders): void
    {
        $this->folders = $folders;
    }

    /**
     * @param string $name
     *
     * @return int|false
     */
    public function hasFolderByName(string $name): int|false
    {
        foreach ($this->folders as $key => $folder) {
            if ($name === $folder->name) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @param FolderModel $folder
     *
     * @return void
     * @throws StructureModelException
     */
    public function addFolder(FolderModel $folder): void
    {
        if (false !== $this->hasFolderByName($folder->name)) {
            throw new StructureModelException(
                'Folder '.$folder->name.' already exist in folder list',
                100
            );
        }

        $this->folders[] = $folder;
    }

    /**
     * @param string $name
     *
     * @return FolderModel
     * @throws StructureModelException
     */
    public function getFolder(string $name): FolderModel
    {
        $folderId = $this->hasFolderByName($name);
        if (false === $folderId) {
            throw new StructureModelException(
                'Folder '.$name.' not exist in folder list',
                101
            );
        }

        return $this->folders[$folderId];
    }

    /**
     * @param FolderModel $folder
     *
     * @return void
     * @throws StructureModelException
     */
    public function removeFolder(FolderModel $folder): void
    {
        $folderId = $this->hasFolderByName($folder->name);
        if (false === $folderId) {
            throw new StructureModelException(
                'Folder '.$folder->name.' not exist in folder list',
                101
            );
        }
        unset($this->folders[$folderId]);
    }
}
