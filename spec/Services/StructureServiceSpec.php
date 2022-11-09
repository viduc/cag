<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Factory\StructureModelFactory;
use Cag\Models\StructureModel;
use Cag\Services\FolderService;
use Cag\Services\StructureService;
use Cag\Constantes\StructureModelConstantes as Constantes;
use Spec\Implentation\Loggers\Logger;

describe('StructureService', function () {
    given('public', function () {
        return str_replace('Services', 'public', __DIR__);
    });
    given('folder', function () {
        return $this->public.DIRECTORY_SEPARATOR."folderStructure";
    });
    beforeEach(
        /**
         * @throws Exception
         */
        function () {
            $this->structureService = new StructureService();
            allow(FolderService::class)
                ->toReceive('getProjectPath')
                ->andReturn($this->public.DIRECTORY_SEPARATOR);
            deleteFolderStructure($this->folder);
        }
    );
    afterEach(function () {
        deleteFolderStructure($this->folder);
    });

    describe('create', function () {
        it(
            'Folder testFolder must exist',
            function () {
                $this->structureService->create(
                    new StructureModel('folderStructure')
                );
                expect(is_dir($this->folder))->toBeTruthy();
            }
        );
        it(
            'Folder testFolder must contain all sub folder in constantes
            StructureModelConstantes',
            function () {
                $factory = new StructureModelFactory(new Logger());
                $this->structureService->create(
                    $factory->getStandard('folderStructure')
                );
                $folders = scandir($this->folder);
                foreach (Constantes::FOLDERS as $folder) {
                    expect(in_array($folder, $folders))->toBeTruthy();
                }
            }
        );
    });
});

function deleteFolderStructure($path)
{
    if (is_dir($path)) {
        $folders = scandir($path);
        foreach ($folders as $folder) {
            if (is_dir($path.DIRECTORY_SEPARATOR.$folder) &&
                '.' !== $folder && '..' !== $folder) {
                rmdir($path.DIRECTORY_SEPARATOR.$folder);
            }
        }
        rmdir($path);
    }
}
