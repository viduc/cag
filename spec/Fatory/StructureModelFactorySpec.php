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
use Spec\Implentation\Loggers\Logger;
use Cag\Factory\StructureModelConst as Constantes;

describe('StructureModelFactory', function () {
    beforeEach(function () {
        $this->factory = new StructureModelFactory(new Logger());
    });
    afterEach(function () {
    });

    describe('getStandard', function () {
        it(
            'should return a structureModel with all standard folders',
            function () {
                $model = $this->factory->getStandard('test');
                foreach (Constantes::FOLDERS as $folder) {
                    expect(false !== $model->hasFolderByName(
                        $folder
                    ))->toBeTruthy();
                }
            }
        );
    });
});
