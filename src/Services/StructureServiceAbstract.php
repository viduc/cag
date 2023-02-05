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

abstract class StructureServiceAbstract implements ServiceInterface
{
    /**
     * @var FolderService
     */
    protected FolderService $folderService;
    /**
     * @var FileService
     */
    protected FileService $fileService;
    public function __construct(
        FileServiceAbstract $fileService,
        FolderServiceAbstract $folderService
    ) {
        $this->fileService = $fileService;
        $this->folderService = $folderService;
    }
    public abstract function create(StructureModel $model): void;
}
