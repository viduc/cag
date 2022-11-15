<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Exceptions\FileException;
use Cag\Exceptions\FolderException;
use Cag\Services\ComposerService;
use Cag\Services\FileService;

describe('ComposerService', function () {
    given('public', function () {
        return str_replace('Services', 'public', __DIR__);
    });
    given('file', function () {
        return $this->public.DIRECTORY_SEPARATOR."composer.json";
    });

    beforeEach(/**
     * @throws FileException
     * @throws FolderException
     */ function () {
        $content = json_encode(
            array("name" => 'viduc/cag'),
            JSON_UNESCAPED_SLASHES
        );var_dump(__DIR__);
        file_put_contents($this->file, $content);
        $this->composerService = new ComposerService($this->file);
    });
    afterEach(function () {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    });

    describe('addAutoload', function () {
        it(
            'should exist a composer.json file with autoload PSR4',
            function () {
                $this->composerService->addAutoload("Test\\", ['test/']);

                $content = json_decode(
                    file_get_contents($this->file),
                    true
                );
                expect(
                    $content['autoload']['psr-4']['Test\\'][0]
                )->toBe('test/');
            }
        );
    });
});
