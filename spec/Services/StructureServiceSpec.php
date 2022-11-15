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

const DS = DIRECTORY_SEPARATOR;

describe('StructureService', function () {

    given('public', function () {
        return str_replace('Services', 'public', __DIR__);
    });
    given('folder', function () {
        return $this->public.DS."folderStructure";
    });
    given('folder1', function () {
        return $this->public.DS."folderStructure1";
    });
    given('folder2', function () {
        return $this->public.DS."folderStructure2";
    });
    given('folder3', function () {
        return $this->public.DS."folderStructure3";
    });
    beforeEach(
        /**
         * @throws Exception
         */
        function () {
            $this->structureService = new StructureService();
            allow(FolderService::class)
                ->toReceive('getProjectPath')
                ->andReturn($this->public.DS);
            deleteFolderStructure($this->folder);
            deleteFolderStructure($this->folder1);
            deleteFolderStructure($this->folder2);
            deleteFolderStructure($this->folder3);
        }
    );
    afterEach(function () {
        deleteFolderStructure($this->folder);
        deleteFolderStructure($this->folder1);
        deleteFolderStructure($this->folder2);
        deleteFolderStructure($this->folder3);
    });

    describe('create', function () {
        it(
            'Folder testFolder must exist',
            function () {
                $this->structureService->create(
                    new StructureModel('folderStructure1')
                );
                expect(is_dir($this->folder1))->toBeTruthy();
            }
        );
        it(
            'Folder testFolder must contain all sub folder in constantes
            StructureModelConstantes',
            function () {
                $factory = new StructureModelFactory();
                $this->structureService->create(
                    $factory->getStandard('folderStructure2')
                );
                $folders = scandir($this->folder2);
                foreach (Constantes::FOLDERS as $folder) {
                    expect(in_array($folder, $folders))->toBeTruthy();
                }
            }
        );
        it(
            'Folders in testFolder must contain all files in constantes
            StructureModelConstantes',
            function () {
                $factory = new StructureModelFactory();
                $this->structureService->create(
                    $factory->getStandard('folderStructure3')
                );
                foreach (Constantes::FILES_IN_FOLDER as $file => $folder) {
                    expect(
                        in_array(
                            $file,
                            scandir($this->folder3.DS.$folder)
                        )
                    )->toBeTruthy();
                }
            }
        );
    });
});

function deleteFolderStructure($path)
{
    if (is_dir($path)) {
        system('rm -rf -- ' . escapeshellarg($path), $rc);
    }
}
