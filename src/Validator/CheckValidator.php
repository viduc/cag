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

class CheckValidator extends ValidatorAbstract
{
    public static function checkFile(string $name, bool $exist = true): void
    {
        if ('' === $name) {
            throw new FolderException(
                'Name of folder must not be empty',
                100
            );
        }

        if (!FolderValidator::isFolderWritable($name)) {
            throw new FolderException(
                "The target folder is invalid",
                101
            );
        }
    }
}