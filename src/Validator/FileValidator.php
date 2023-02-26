<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Validator;

use Cag\Exceptions\FileException;
use Cag\Exceptions\FolderException;
use Cag\Exceptions\NameException;

class FileValidator extends ValidatorAbstract
{
    /**
     * @param string $name
     * @param bool $exist
     *
     * @return void
     * @throws FileException|NameException
     */
    public static function checkFile(string $name, bool $exist = true): void
    {
        CheckValidator::checkFile($name, $exist);

        if ($exist && file_exists($name)) {
            throw new FileException(
                "The file already exists",
                102
            );
        }
    }
}
