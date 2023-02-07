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

use Cag\Containers\Exceptions\DependencyInjectionException;
use Cag\Exceptions\FileException;
use Cag\Exceptions\FolderException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Models\StructureModel;

class StructureService extends StructureServiceAbstract
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * @param StructureModel $model
     * @return void
     * @throws FileException
     * @throws FolderException
     */
    public function create(StructureModel $model): void
    {
        $this->folderService->create(
            $this->folderService->getProjectPath().$model->getPath()
        );
        foreach ($model->getFolders() as $folder) {
            $this->folderService->create(
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
