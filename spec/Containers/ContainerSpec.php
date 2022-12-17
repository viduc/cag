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
use Cag\Exceptions\NotFoundException;
use Cag\Services\ComposerService;
use Cag\Services\FileService;
use Cag\Services\ServiceInterface;
use Spec\Implentation\Containers\Container as externalContainer;

describe('Test on Container class', function () {
    given('public', function () {
        return str_replace('Containers', 'public', __DIR__);
    });
    given('file', function () {
        return $this->public.DIRECTORY_SEPARATOR."composer.json";
    });
    beforeEach(function () {
        $this->container = new Container(new externalContainer());
        $content = json_encode(
            array("name" => 'viduc/cag'),
            JSON_UNESCAPED_SLASHES
        );
        file_put_contents($this->file, $content);
    });
    afterEach(function () {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    });

    describe('Test on method get', function () {
        it(
            'should return an instanced FileService class',
            function () {
                $class = $this->container->get(FileService::class);
                expect($class)->toBeAnInstanceOf(FileService::class);
            }
        );
        it(
            'should return an instanced ComposerService class with 
            string parameter',
            function () {
                $this->container->addParams(['composerFile' => $this->file]);
                $class = $this->container->get(ComposerService::class);
                expect($class)->toBeAnInstanceOf(ComposerService::class);
            }
        );
        it(
            'should return an NotFoundException cause container dont 
            find implementation',
            function () {
                $closure = function () {
                    $this->container->get(ServiceInterface::class);
                };
                expect($closure)->toThrow(new NotFoundException());
            }
        );
    });
});
