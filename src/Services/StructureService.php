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

use Cag\Exceptions\ContainerException;
use Cag\Exceptions\FileException;
use Cag\Exceptions\FolderException;
use Cag\Exceptions\NotFoundException;
use Cag\Models\StructureModel;

class StructureService extends ServiceAbstract
{
    const DS = DIRECTORY_SEPARATOR;
    /**
     * @var FolderService
     */
    protected FolderService $folderService;
    /**
     * @var FileService
     */
    protected FileService $fileService;

    /**
     * @param StructureModel $model
     *
     * @return void
     * @throws FolderException|FileException|NotFoundException|ContainerException
     */
    public function create(StructureModel $model): void
    {
        $this->folderService = $this->container()->get(FolderService::class);
        $this->fileService = $this->container()->get(FileService::class);
        $this->folderService->create(
            $this->folderService->getProjectPath().$model->getPath()
        );
        foreach ($model->getFolders() as $folder) {
            $this->container()->get(folderService::class)->create(
                $this->folderService->getProjectPath().
                $model->getPath().self::DS.$folder->getName()
            );
        }
        foreach ($model->getFiles() as $file) {
            $path = $this->folderService->getProjectPath().
                $model->getPath().self::DS.$file->getParent()->getName().
                self::DS.$file->getName();
            $this->fileService->create($path, $file->getContent());
        }
    }
}
