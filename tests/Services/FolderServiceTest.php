<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */


namespace Cag\Tests\Services;

use Cag\Services\FolderService;
use PHPUnit\Framework\TestCase;

class FolderServiceTest extends TestCase
{
    private FolderService $folderService;
    private string $source = '';
    private string $target = '';
    public function setUp(): void
    {
        parent::setUp();
        $this->folderService = new FolderService();
        $this->source = str_replace('tests/Services', 'src/Sources', __DIR__);
        $this->target = str_replace('Services', 'Target', __DIR__);
        $this->cleanDirectory($this->target);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->cleanDirectory($this->target);
    }

    /**
     * @return void
     */
    public function testCopy(): void
    {
        $this->folderService->copy(
            $this->source,
            $this->target
        );
        $this->verifyDirectory($this->source, $this->target);
    }

    /**
     * @param string $source
     * @param string $target
     * @return void
     */
    private function verifyDirectory(string $source, string $target): void
    {
        $d = dir($source);
        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            if (is_dir($source . DIRECTORY_SEPARATOR . $entry)) {
                $this->assertDirectoryExists(
                    $target . DIRECTORY_SEPARATOR . $entry
                );
                $this->verifyDirectory(
                    $source . DIRECTORY_SEPARATOR . $entry,
                    $target . DIRECTORY_SEPARATOR . $entry
                );
            }
            if (is_file($source . DIRECTORY_SEPARATOR . $entry)) {
                $this->assertFileExists(
                    $target . DIRECTORY_SEPARATOR . $entry
                );
            }
        }
    }

    private function cleanDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }
        $files = array_diff(scandir($directory), array('.','..'));

        foreach ($files as $file) {

            (is_dir($directory . DIRECTORY_SEPARATOR . $file)) ?
                self::cleanDirectory($directory . DIRECTORY_SEPARATOR . $file) :
                unlink($directory . DIRECTORY_SEPARATOR . $file);

        }
        rmdir($directory);
    }
}