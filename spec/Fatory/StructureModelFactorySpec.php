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
use Cag\Factory\StructureModelFactory;
use Cag\Models\FileModel;
use Cag\Models\FolderModel;
use Spec\Implentation\Loggers\Logger;

describe('StructureModelFactory', function () {
    beforeEach(function () {
        $this->factory = new StructureModelFactory(new Logger());
    });
    afterEach(function () {
    });

    describe('getStandard', function () {
        it(
            'should return a structureModel with all folder and files in 
                constantes StructureModelConstantes',
            function () {
                $model = $this->factory->getStandard('test');
                foreach (Constantes::FOLDERS as $folderName) {
                    $folder = new FolderModel($folderName);
                    expect(false !== $model->hasFolder(
                        $folder
                    ))->toBeTruthy();
                }
                foreach (Constantes::FILES_IN_FOLDER as
                     $fileName => $folderName
                ) {
                    $folder = new FolderModel($folderName);
                    $file = new FileModel($fileName);
                    $file->setParent($folder);
                    expect(false !== $model->hasFile(
                        $file
                    ))->toBeTruthy();
                }
            }
        );
    });
});
