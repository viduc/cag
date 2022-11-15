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

class ComposerService implements ServiceInterface
{
    /**
     * @var string
     */
    private string $composerFile;

    /**
     * @var array
     */
    private array $composer;

    /**
     * @param string $composerFile
     *
     * @throws FileException
     * @throws FolderException
     */
    public function __construct(string $composerFile)
    {
        FileValidatorAbstract::checkFile($composerFile, false);
        $this->composerFile = $composerFile;
        $this->loadComposer();
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
