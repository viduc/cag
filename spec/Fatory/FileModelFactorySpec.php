<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Factory\FileModelFactory;

describe('FileModelFactory', function () {
    beforeEach(function () {
        $this->factory = new FileModelFactory();
    });
    afterEach(function () {
    });

    describe('get', function () {
        it(
            'should return a FileModel with type contain in file name',
            function () {
                expect($this->factory->getStandard('testInterface')
                    ->isInterface())->toBeTruthy();
                expect($this->factory->getStandard('testAbstract')
                    ->isAbstract())->toBeTruthy();
                expect($this->factory->getStandard('test')
                    ->isClass())->toBeTruthy();
            }
        );
    });
});
