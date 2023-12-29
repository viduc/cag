<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Services;

use Cag\Exceptions\FolderException;
use Cag\Exceptions\NameException;
use Cag\Validator\FolderValidator;

class FolderService extends FolderServiceAbstract
{
    /**
     * @param string $name
     * @return void
     * @throws FolderException
     * @throws NameException
     */
    #[\Override]
    public function create(string $name): void
    {
        FolderValidator::checkFile(name: $name);
        if (mkdir(directory: $name) === false) {
            throw new FolderException(
                message: "An undetermined error occurred during the 
                folder creation: ".$name,
                code: 103
            );
        }
    }

    /**
     * @param string $source
     * @param string $target
     * @param bool $recursive
     * @return void
     */
    #[\Override]
    public function copy(
        string $source,
        string $target,
        bool $recursive = true
    ): void {
        if (is_dir(filename: $source)) {
            try {
                $this->create(name: $target);
            } catch (FolderException|NameException) {}
            $this->copyDir(source: $source, target: $target);
        } else {
            copy(from: $source, to: $target);
        }
    }

    /**
     * @param string $source
     * @param string $target
     * @return void
     */
    private function copyDir(string $source, string $target): void
    {
        $d = dir(directory: $source);
        while (($entry = $d->read()) !== false) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $this->copy(
                source: $source . DIRECTORY_SEPARATOR . $entry,
                target: $target . DIRECTORY_SEPARATOR . $entry
            );
        }

        $d->close();
    }
}
