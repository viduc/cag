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

use Cag\Models\StructureModel;

class StructureService extends StructureServiceAbstract
{
    const DS = DIRECTORY_SEPARATOR;

    public function __construct(protected FolderServiceAbstract $folderService)
    {}

    /**
     * @param StructureModel $model
     * @return void
     */
    public function create(StructureModel $model): void
    {
        $this->folderService->copy(
            str_replace('Services', 'Sources', __DIR__),
            $this->folderService->getProjectPath().$model->getPath()

        );
    }
}
