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

use Cag\Exceptions\FileException;
use Cag\Exceptions\FolderException;
use Cag\Validator\FileValidatorAbstract;

class FileService implements ServiceInterface
{
    /**
     * @param string $name
     * @param string $contenu
     * @return void
     * @throws FileException
     */
    public function create(string $name, string $contenu = ''): void
    {
        FileValidatorAbstract::checkFile($name);
        if (false === file_put_contents($name, $contenu, LOCK_EX)) {
            throw new FileException(
                "An undetermined error occurred during the
                 file creation: ".$name,
                103
            );
        }
    }

    /**
     * @param string $name
     * @param string $contenu
     * @param bool $append
     *
     * @return void
     * @throws FileException|FolderException
     */
    public function update(
        string $name,
        string $contenu = '',
        bool $append = false
    ): void {
        FileValidatorAbstract::checkFile($name, false);
        $append = $append ? FILE_APPEND : null;
        if (false === file_put_contents(
            $name,
            $contenu,
            LOCK_EX | $append
        )) {
            throw new FileException(
                "Une erreur indéterminée est survenue lors de la
                création du fichier: ".$name,
                103
            );
        }
    }

    /**
     * @param string $name
     *
     * @return bool
     * @throws FileException
     */
    public function delete(string $name): bool
    {
        if (!file_exists($name)) {
            throw new FileException(
                'Delete file operation is failure',
                104
            );
        }

        return unlink($name);
    }
}
