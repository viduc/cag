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

use Cag\Exceptions\NameException;

class CheckValidator extends ValidatorAbstract
{
    /**
     * @param string $name
     * @param bool $exist
     * @return void
     * @throws NameException
     */
    public static function checkFile(string $name, bool $exist = true): void
    {
        if ('' === $name) {
            throw new NameException(
                'Name must not be empty',
                100
            );
        }

        if (!FolderValidator::isFolderWritable($name)) {
            throw new NameException(
                "The target is invalid",
                101
            );
        }
    }
}