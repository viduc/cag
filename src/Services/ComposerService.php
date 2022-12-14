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
use Cag\Exceptions\NotFoundException;
use Cag\Validator\FileValidator;

class ComposerService implements ServiceInterface
{
    const DS = DIRECTORY_SEPARATOR;

    /**
     * @var string
     */
    private string $composerFile;

    /**
     * @var array
     */
    private array $composer;

    /**
     * @param string|null $composerFile
     *
     * @throws FileException
     * @throws FolderException|NotFoundException
     */
    public function __construct(?string $composerFile = null)
    {
        $composerFile = $composerFile ?? $this->findComposerFile(__DIR__);
        FileValidator::checkFile($composerFile, false);
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
        $path = str_replace($search, '', $path);
        $path = str_ends_with($path, self::DS) ?
            substr($path, 0, -1) : $path;

        foreach (scandir($path) as $file) {
            if (is_file($path.self::DS.$file) &&
                'composer.json' === $file
            ) {
                return $path.self::DS.$file;
            }
        }
        if ($path === self::DS) {
            throw new NotFoundException(
                'composer.json file not found',
                100
            );
        }
        return $this->findComposerFile(
            substr($path, 0, strripos($path, self::DS))
        );
    }

    /**
     * @param string $key
     * @param array  $value
     *
     * @return void
     */
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
            file_get_contents($this->composerFile),
            true
        );
    }

    /**
     * @return void
     */
    private function saveComposer(): void
    {
        file_put_contents(
            $this->composerFile,
            json_encode(
                $this->composer,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }
}
