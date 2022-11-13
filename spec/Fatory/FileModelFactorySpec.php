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
use Cag\Models\FileModel;

describe('FileModelFactory', function () {
    beforeEach(function () {
        $this->factory = new FileModelFactory();
    });
    afterEach(function () {
    });

    describe('get', function () {
        it(
            'should return a FileModel',
            function () {
                expect($this->factory->get('test'))
                    ->toBeAnInstanceOf(FileModel::class);
            }
        );
    });
});
