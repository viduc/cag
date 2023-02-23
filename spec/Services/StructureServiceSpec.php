<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Constantes\StructureModelConstantes as Constantes;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Factory\Model\FileModelFactory;
use Cag\Factory\Model\FolderModelFactory;
use Cag\Factory\Model\StructureModelFactory;
use Cag\Models\StructureModel;
use Cag\Services\FileService;
use Cag\Services\FolderService;
use Cag\Services\StructureService;

const DS = DIRECTORY_SEPARATOR;

describe('Test on StructureService Class', function () {
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
            $this->folderService = new FolderService();
            $this->fileService = new FileService();
            $this->structureService = new StructureService(
                $this->fileService,
                $this->folderService
            );
            $this->fileModelFactory = new FileModelFactory();
            $this->folderModelFactory = new FolderModelFactory();
            $this->factory = new StructureModelFactory(
                $this->fileModelFactory,
                $this->folderModelFactory
            );

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

    describe('Test on method create', function () {
        it(
            'Folder testFolder must exist',
            function () {
                $this->structureService->create(
                    new StructureModel(
                        'folderStructure1',
                        'folderStructure1'
                    )
                );
                expect(is_dir($this->folder1))->toBeTruthy();
            }
        );
        it(
            'Folder testFolder must contain all sub folder in constantes
            StructureModelConstantes',
            /**
             * @throws ContainerException
             * @throws NotFoundException
             */
            function () {
                $this->structureService->create(
                    $this->factory->getStandard(
                        'folderStructure2',
                        'folderStructure2'
                    )
                );
                $folders = scandir($this->folder2);
                foreach (Constantes::FOLDERS as $folder) {
                    if (str_contains($folder, DS)) {
                        $subFolders = explode(DS, $folder);
                        expect(in_array(
                            $subFolders[1],
                            scandir($this->folder2.DS.$subFolders[0])
                        ))->toBeTruthy();
                    } else {
                        expect(in_array($folder, $folders))->toBeTruthy();
                    }
                }
            }
        );
        it(
            'Folders in testFolder must contain all files in constantes
            StructureModelConstantes',
            /**
             * @throws ContainerException
             * @throws NotFoundException
             */
            function () {
                $this->structureService->create(
                    $this->factory->getStandard(
                        'folderStructure3',
                        'folderStructure3'
                    )
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
