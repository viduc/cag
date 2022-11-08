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
use Cag\Validator\FolderValidatorAbstract;

class FolderService implements ServiceInterface
{
    /**
     * @param string $name
     *
     * @return void
     * @throws FolderException
     */
    public function create(string $name): void
    {
        FolderValidatorAbstract::checkFile($name);
        if (false === mkdir($name)) {
            throw new FolderException(
                "An undetermined error occurred during the 
                folder creation: ".$name,
                103
            );
        }
    }

    /**
     * @param string $name
     *
     * @return void
     * @throws FolderException
     */
    public function delete(string $name): void
    {
        FolderValidatorAbstract::checkFile($name, false);
        if (!is_dir($name)) {
            throw new FolderException(
                "The target folder is invalid",
                101
            );
        }
        if (false === rmdir($name)) {
            throw new FolderException(
                "An undetermined error occurred during the 
                folder suppression: ".$name,
                103
            );
        }
    }

    /**
     * @return string
     */
    public function getProjectPath(): string
    {
        $explode = explode('vendor', $this->getFullPath());

        return $explode[0];
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return __DIR__;
    }
}
