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
use Cag\Exceptions\NameException;
use Cag\Exceptions\NotFoundException;
use Cag\Services\ComposerService;

describe(
    message: 'ComposerService',
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
            name: 'file',
            value: function () {
                return $this->public.DIRECTORY_SEPARATOR."composer.json";
            }
        );

        beforeEach(
            /**
             * @throws NotFoundException|FileException|NameException
             */
            function () {
                $content = json_encode(
                    value: array("name" => 'viduc/cag'),
                    flags: JSON_UNESCAPED_SLASHES
                );
                file_put_contents(filename: $this->file, data: $content);
                $this->composerService = new ComposerService(
                    composerFile: $this->file
                );
            }
        );
        afterEach(
            closure: function () {
                if (file_exists(filename: $this->file)) {
                    unlink(filename: $this->file);
                }
            }
        );

        describe(
            message: 'addAutoload',
            closure: function () {
                it(
                    message: 'should exist a composer.json file with autoload PSR4',
                    closure: function () {
                        $this->composerService->addAutoload(
                            key: "Test\\",
                            value: ['test/']
                        );
                        $content = json_decode(
                            json: file_get_contents(filename: $this->file),
                            associative: true
                        );
                        expect(
                            actual: $content['autoload']['psr-4']['Test\\'][0]
                        )->toBe(expected: 'test/');
                    }
                );
            }
        );
    }
);
