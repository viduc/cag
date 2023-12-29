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

use Cag\Exceptions\FolderException;
use Cag\Exceptions\NameException;

class FolderValidator extends ValidatorAbstract
{
    /**
     * @param string $name
     * @param bool $exist
     * @return void
     * @throws FolderException
     * @throws NameException
     */
    public static function checkFile(string $name, bool $exist = true): void
    {
        CheckValidator::checkFile(name: $name);

        if ($exist && is_dir($name)) {
            throw new FolderException(
                message: "The folder already exists",
                code: 102
            );
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function isFolderWritable(string $name): bool
    {
        $folder = dirname(path: $name);

        return is_writable(filename: $folder);
    }
}