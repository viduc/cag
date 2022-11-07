<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Exception\FileException;
use Cag\Exception\FolderException;
use Cag\Service\FileService;

describe('FileService', function () {
    given('public', function () {
        return str_replace('Controller', 'public', __DIR__);
    });
    given('file', function () {
        return $this->public.DIRECTORY_SEPARATOR."testPresent";
    });

    beforeEach(function () {
        $this->fileService = new FileService();
    });
    afterEach(function () {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    });

    describe('create and update', function () {
        it(
            'should return a FileException if name of file is empty',
            function () {
                $closure = function () {
                    $this->fileService->create('');
                };
                expect($closure)->toThrow(new FileException(
                    'Name of file must not be empty',
                    100
                ));
                $closure = function () {
                    $this->fileService->update('');
                };
                expect($closure)->toThrow(new FileException(
                    'Name of file must not be empty',
                    100
                ));
            }
        );
        it(
            'should return a FileException if name of file is not valid',
            function () {
                $closure = function () {
                    $this->fileService->create(
                        DIRECTORY_SEPARATOR."ziap".DIRECTORY_SEPARATOR."test"
                    );
                };
                expect($closure)->toThrow(new FolderException(
                    "The target folder is invalid",
                    101
                ));
                $closure = function () {
                    $this->fileService->update(
                        DIRECTORY_SEPARATOR."ziap".DIRECTORY_SEPARATOR."test"
                    );
                };
                expect($closure)->toThrow(new FolderException(
                    "The target folder is invalid",
                    101
                ));
            }
        );
    });

    describe('create', function () {
        it(
            'should return a FileException if file is present',
            function () {
                touch($this->file);
                $file = $this->file;
                $closure = function () use ($file) {
                    $this->fileService->create($file);
                };
                expect($closure)->toThrow(new FileException(
                    "The file already exists",
                    102
                ));
            }
        );
        it(
            'File with name send must be created',
            function () {
                $this->fileService->create($this->file);
                expect(file_exists($this->file))->toBeTruthy();
            }
        );
    });
    describe('update', function () {
        it(
            'The file with content "to modify" must content only "test"
            after update',
            function () {
                file_put_contents($this->file, "to modify");
                $this->fileService->update($this->file, "test");
                expect(file_get_contents($this->file))->toBe("test");
            }
        );
        it(
            'The file with content "to modify" must content 
            "to modify test" after update',
            function () {
                file_put_contents($this->file, "to modify");
                $this->fileService->update($this->file, " test", true);
                expect(file_get_contents($this->file))->toBe(
                    "to modify test"
                );
            }
        );
    });
    describe('delete', function () {
        it(
            'shoud return a FileException if file is not present',
            function () {
                $closure = function () {
                    $this->fileService->delete(
                        DIRECTORY_SEPARATOR."ziap".DIRECTORY_SEPARATOR."test"
                    );
                };
                expect($closure)->toThrow(new FileException(
                    "Delete file operation is failure",
                    104
                ));
            }
        );
        it(
            'shoud return a FileException if file is not deletable',
            function () {
                file_put_contents($this->file, "to delete");
                expect($this->fileService->delete($this->file))->toBeTruthy();
            }
        );
    });
});
