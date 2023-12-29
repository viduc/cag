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
use Cag\Exceptions\NameException;
use Cag\Exceptions\NotFoundException;
use Cag\Validator\FileValidator;

class ComposerService extends ComposerServiceAbstract
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * @var string
     */
    private string $composerFile;

    /**
     * @var array|null
     */
    private array|null $composer;

    /**
     * @param string|null $composerFile
     *
     * @throws FileException
     * @throws NotFoundException|NameException
     */
    public function __construct(string|null $composerFile = null)
    {
        $composerFile = $composerFile ?? $this->findComposerFile(path: __DIR__);
        FileValidator::checkFile(name: $composerFile, exist: false);
        $this->composerFile = $composerFile;
        $this->loadComposer();
    }

    /**
     * @param string $path
     *
     * @return string
     * @throws NotFoundException
     */
    private function findComposerFile(string $path): string
    {
        $search = self::DS.'vendor'.self::DS.'viduc'.self::DS.'cag'.self::DS;
        $search .= 'src'.self::DS.'Services';
        $path = str_replace(search: $search, replace: '', subject: $path);
        $path = str_ends_with(haystack: $path, needle: self::DS) ?
            substr(string: $path, offset: 0, length: -1) : $path;

        foreach (scandir(directory: $path) as $file) {
            if (is_file(filename: $path.self::DS.$file) &&
                $file === 'composer.json'
            ) {
                return $path.self::DS.$file;
            }
        }
        if ($path === self::DS) {
            throw new NotFoundException(
                message: 'composer.json file not found',
                code: 100
            );
        }
        return $this->findComposerFile(
            path: substr(
                string: $path,
                offset: 0,
                length: strripos(haystack: $path, needle: self::DS)
            )
        );
    }

    /**
     * @param string $key
     * @param array  $value
     *
     * @return void
     */
    #[\Override]
    public function addAutoload(string $key, array $value): void
    {
        if (!isset($this->composer['autoload']['psr-4'][$key])) {
            $this->composer['autoload']['psr-4'][$key] = $value;
        }
        $this->saveComposer();
    }

    /**
     * @return void
     */
    private function loadComposer(): void
    {
        $this->composer = json_decode(
            json: file_get_contents(filename: $this->composerFile),
            associative: true
        );
    }

    /**
     * @return void
     */
    private function saveComposer(): void
    {
        file_put_contents(
            filename: $this->composerFile,
            data: json_encode(
                value: $this->composer,
                flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }
}
