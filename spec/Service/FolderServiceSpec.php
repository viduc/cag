<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Exception\FolderException;
use Cag\Service\FolderService;

describe('FileService', function () {
    given('public', function (){
        return str_replace('Controller', 'public', __DIR__);
    });
    given('folder', function () {
        return $this->public.DIRECTORY_SEPARATOR."folderPresent";
    });

    beforeEach(function () {
        $this->folderService = new FolderService();
    });
    afterEach(function () {
        if (is_dir($this->folder)) {
            rmdir($this->folder);
        }
    });

    describe('create', function () {
        it('should return a FileException if name of file is empty',
            function () {
                $closure = function () {$this->folderService->create('');};
                expect($closure)->toThrow(new FolderException(
                    'Name of folder must not be empty',
                    100
                ));
            }
        );
        it('should return a FolderException if name of folder is not
            valid',
            function () {
                $closure = function () {
                    $this->folderService->create(
                        DIRECTORY_SEPARATOR."ziap".DIRECTORY_SEPARATOR."test"
                    );
                };
                expect($closure)->toThrow(new FolderException(
                    'The target folder is invalid',
                    101
                ));
            }
        );
        it('should return a FolderException if folder already exist',
            function () {
                mkdir($this->folder);
                $closure = function () {
                    $this->folderService->create($this->folder);
                };
                expect($closure)->toThrow(new FolderException(
                    'The folder already exists',
                    102
                ));
            }
        );
        it('Folder "folderPresent" must be present',
            function () {
                $this->folderService->create($this->folder);
                expect(is_dir($this->folder))->toBeTruthy();
            }
        );
    });
});
