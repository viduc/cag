<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Service;

use Cag\Exception\FolderException;
use Cag\Validator\FolderValidatorAbstract;

class FolderService implements ServiceInterface
{
    /**
     * @param string $name
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
}