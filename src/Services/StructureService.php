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

use Cag\Exceptions\FolderException;
use Cag\Models\StructureModel;

class StructureService implements ServiceInterface
{
    const DS = DIRECTORY_SEPARATOR;
    /**
     * @var FolderService
     */
    private FolderService $folderService;

    /**
     * @var FileService
     */
    private FileService $fileService;

    public function __construct()
    {
        $this->folderService = new FolderService();
        $this->fileService = new FileService();
    }

    /**
     * @param StructureModel $model
     *
     * @return void
     * @throws FolderException
     */
    public function create(StructureModel $model): void
    {
        $this->folderService->create(
            $this->folderService->getProjectPath().$model->getSrcName()
        );
        foreach ($model->getFolders() as $folder) {
            $this->folderService->create(
                $this->folderService->getProjectPath().
                $model->getSrcName().DS.$folder->getName()
            );
        }
        foreach ($model->getFiles() as $file) {
            $this->fileService->create(
                $this->folderService->getProjectPath().
                $model->getSrcName().DS.$file->getParent()->getName().
                DS.$file->getName()
            );
        }
    }
}
