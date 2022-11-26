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

use Cag\Exceptions\StructureModelException;

class StructureModel extends ModelAbstract
{
    const DS = DIRECTORY_SEPARATOR;

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
     * @var string
     */
    public string $path;

    /**
     * @var FileModel[]
     */
    public array $files = [];

    /**
     * @param string $srcName
     * @param string $path
     */
    public function __construct(string $srcName, string $path = 'src')
    {
        $this->srcName = $srcName;
        $this->path = $path;
        $this->formatPath();
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
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
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
     * @return void
     */
    private function formatPath(): void
    {
        $this->path = rtrim(
            ltrim(
                str_replace(['/', '\\'], self::DS, $this->path),
                self::DS
            ),
            self::DS
        );
    }

    /**
     * @param FolderModel $folder
     *
     * @return int|false
     */
    public function hasFolder(FolderModel $folder): int|false
    {
        foreach ($this->folders as $key => $value) {
            if ($folder->isEqual($value)) {
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
        if (false !== $this->hasFolder($folder)) {
            throw new StructureModelException(
                'Folder '.$folder->name.' already exist in folder list',
                100
            );
        }

        $this->folders[] = $folder;
    }

    /**
     * @param FolderModel $folder
     *
     * @return void
     * @throws StructureModelException
     */
    public function removeFolder(FolderModel $folder): void
    {
        $folderId = $this->hasFolder($folder);
        if (false === $folderId) {
            throw new StructureModelException(
                'Folder '.$folder->name.' not exist in folder list',
                101
            );
        }
        unset($this->folders[$folderId]);
    }

    /**
     * @return FileModel[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @param FileModel[] $files
     */
    public function setFiles(array $files): void
    {
        $this->files = $files;
    }

    /**
     * @param FileModel $file
     *
     * @return int|false
     */
    public function hasFile(FileModel $file): int|false
    {
        foreach ($this->files as $key => $value) {
            if ($file->isEqual($value)) {
                return $key;
            }
        }

        return false;
    }

    /**
     * @param FileModel $file
     *
     * @return void
     * @throws StructureModelException
     */
    public function addFile(FileModel $file): void
    {
        if (false !== $this->hasFile($file)) {
            throw new StructureModelException(
                'File '.$file->name.' already exist in file list',
                102
            );
        }

        $this->files[] = $file;
    }

    /**
     * @param FileModel $file
     *
     * @return void
     * @throws StructureModelException
     */
    public function removeFile(FileModel $file): void
    {
        $fileId = $this->hasFile($file);
        if (false === $fileId) {
            throw new StructureModelException(
                'File '.$file->name.' not exist in file list',
                103
            );
        }
        unset($this->files[$fileId]);
    }
}
