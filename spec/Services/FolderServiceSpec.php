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
use Cag\Exceptions\NameException;
use Cag\Services\FolderService;

const DS = DIRECTORY_SEPARATOR;

describe(
    message: 'FolderService',
    closure: function () {
        given(
            name: 'public',
            value: function () {
                return str_replace(
                    search: 'Services',
                    replace: 'public',
                    subject: __DIR__
                );
            }
        );
        given(
            name: 'folder',
            value: function () {
                return $this->public.DIRECTORY_SEPARATOR."folderPresent";
            }
        );

        beforeEach(closure: function () {
            $this->folderService = new FolderService();
        });
        afterEach(
            closure: function () {
                if (is_dir(filename: $this->folder)) {
                    rmdir(directory: $this->folder);
                }
            }
        );

        describe(
            message: 'Return exception when trying create',
            closure: function () {
                with_provided_data_it(
                    message: 'should return a NameException with message: "{:0}" and code: "{:1}"',
                    closure: function($message, $code, $closure) {
                        expect(actual: $closure)->toThrow(
                            expected: new NameException(
                                message: $message,
                                code: $code
                            )
                        );
                    },
                    provider: function () {
                        yield [
                            'Name must not be empty',
                            100,
                            function () {
                                $this->folderService->create(name: '');
                            }
                        ];
                        yield [
                            'The target is invalid',
                            101,
                            function () {
                                $this->folderService->create(
                                    name: DIRECTORY_SEPARATOR."ziap"
                                    .DIRECTORY_SEPARATOR."test"
                                );
                            }
                        ];
                    }
                );
                it(
                    message: 'should return a FolderException if folder already exist',
                    closure: function () {
                        mkdir(directory: $this->folder);
                        $closure = function () {
                            $this->folderService->create(name: $this->folder);
                        };
                        expect(actual: $closure)->toThrow(
                            expected: new FolderException(
                                message: 'The folder already exists',
                                code: 102
                            )
                        );
                    }
                );
            }
        );
        describe(
            message: 'Create folder',
            closure: function () {
                it(
                    message: 'Folder "folderPresent" must be present',
                    closure: function () {
                        $this->folderService->create(name: $this->folder);
                        expect(
                            actual: is_dir(filename: $this->folder)
                        )->toBeTruthy();
                    }
                );
            }
        );
        describe(
            message: 'Validate path',
            closure: function () {
                it(
                    message: 'The returned path must end with cag',
                    /**
                     * @throws Exception
                     */
                    closure: function () {
                        allow(
                            actual: $this->folderService
                        )->toReceive('getFullPath')->andRun(
                            function () {
                                return str_replace(
                                    search: 'spec'.DIRECTORY_SEPARATOR.'Service',
                                    replace: 'vendor'.DIRECTORY_SEPARATOR.'viduc',
                                    subject: __DIR__
                                );
                            }
                        );
                        expect(
                            actual: str_ends_with(
                                haystack: $this->folderService->getProjectPath(),
                                needle: 'cag/'
                            )
                        )->toBeTruthy();
                    }
                );
            }
        );
    }
);
