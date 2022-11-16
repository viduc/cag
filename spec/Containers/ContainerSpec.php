<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Containers\Container;
use Cag\Services\FileService;
use Spec\Implentation\Containers\Container as externalCntainer;

describe('Container', function () {
    beforeEach(function () {
        $this->container = new Container(new externalCntainer());
    });

    describe('get', function () {
        it(
            'should return an instanced class',
            function () {
                $class = $this->container->get(FileService::class);
                expect($class)->toBeAnInstanceOf(FileService::class);
            }
        );
    });
});
