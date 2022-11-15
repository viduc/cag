<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Exceptions\FolderException;
use Cag\Services\FolderService;

const DS = DIRECTORY_SEPARATOR;

describe('FileService', function () {
    given('public', function () {
        return str_replace('Services', 'public', __DIR__);
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

    describe('create and delete', function () {
        it(
            'should return a FileException if name of folder is empty
            and is not valid',
            function () {
                $closure = function () {
                    $this->folderService->create('');
                };
                expect($closure)->toThrow(new FolderException(
                    'Name of folder must not be empty',
                    100
                ));
                $closure = function () {
                    $this->folderService->create(DS . "ziap" . DS . "test");
                };
                expect($closure)->toThrow(new FolderException(
                    'The target folder is invalid',
                    101
                ));

                $closure = function () {
                    $this->folderService->delete('');
                };
                expect($closure)->toThrow(new FolderException(
                    'Name of folder must not be empty',
                    100
                ));
                $closure = function () {
                    $this->folderService->delete(DS . "ziap" . DS . "test");
                };
                expect($closure)->toThrow(new FolderException(
                    'The target folder is invalid',
                    101
                ));
            }
        );
    });
    describe('create', function () {
        it(
            'should return a FolderException if folder already exist',
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
        it(
            'Folder "folderPresent" must be present',
            function () {
                $this->folderService->create($this->folder);
                expect(is_dir($this->folder))->toBeTruthy();
            }
        );
    });

    describe('delete', function () {
        it(
            'should return a FileException if folder not exist',
            function () {
                $closure = function () {
                    $this->folderService->delete($this->folder);
                };
                expect($closure)->toThrow(new FolderException(
                    'The target folder is invalid',
                    101
                ));
            }
        );
        it(
            'The folder must be deleted',
            function () {
                mkdir($this->folder);
                expect(is_dir($this->folder))->toBeTruthy();
                $this->folderService->delete($this->folder);
                expect(is_dir($this->folder))->toBeFalsy();
            }
        );
    });

    it(
        'The returned path must end with cag',
        function () {
            allow($this->folderService)->toReceive('getFullPath')->andRun(
                function () {
                    return str_replace(
                        'spec'.DS.'Service',
                        'vendor'.DS.'viduc',
                        __DIR__
                    );
                }
            );
            expect(
                str_ends_with(
                    $this->folderService->getProjectPath(),
                    'cag/'
                )
            )->toBeTruthy();
        }
    );
});
