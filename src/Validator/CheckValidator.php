<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
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
     * @throws NameException
     */
    public static function checkFile(string $name): void
    {
        if ('' === $name) {
            throw new NameException(message: 'Name must not be empty', code: 100);
        }

        if (!FolderValidator::isFolderWritable(name: $name)) {
            throw new NameException(message: 'The target is invalid', code: 101);
        }
    }
}
