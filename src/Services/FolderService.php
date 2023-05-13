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
    public function create(string $name): void
    {
        FolderValidator::checkFile($name);
        if (false === mkdir($name)) {
            throw new FolderException(
                "An undetermined error occurred during the 
                folder creation: ".$name,
                103
            );
        }
    }

    /**
     * @param string $source
     * @param string $target
     * @param bool $recursive
     * @return void
     */
    public function copy(
        string $source,
        string $target,
        bool $recursive = true
    ): void {
        if (is_dir($source)) {
            try {
                $this->create($target);
            } catch (FolderException|NameException) {}
            $this->copyDir($source, $target);
        } else {
            copy($source, $target);
        }
    }

    private function copyDir(string $source, string $target): void
    {
        $d = dir($source);
        while (false !== ($entry = $d->read())) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $this->copy(
                $source . DIRECTORY_SEPARATOR . $entry,
                $target . DIRECTORY_SEPARATOR . $entry
            );
        }

        $d->close();
    }
}
