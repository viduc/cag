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

use Cag\Exception\FileException;

class FileValidatorAbstract implements ValidatorInterface
{
    /**
     * @param string $name
     * @param bool $exist
     * @return void
     * @throws FileException
     */
    public static function checkFile(string $name, bool $exist = true): void
    {
        if ('' === $name) {
            throw new FileException(
                'Name of file must not be empty',
                100
            );
        }

        if (!FileValidatorAbstract::isFolderWritable($name)) {
            throw new FileException(
                "The target folder is invalid",
                101
            );
        }

        if ($exist && file_exists($name)) {
            throw new FileException(
                "The file already exists",
                102
            );
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public static function isFolderWritable($name): bool
    {
        $folder = dirname($name);

        return is_writable($folder);
    }
}