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
    #[\Override]
    public function setUp(): void
    {
        $this->folderService = new FolderService();
        $this->source = str_replace(
            search: 'tests/Services',
            replace: 'src/Sources',
            subject: __DIR__
        );
        $this->target = str_replace(
            search: 'Services',
            replace: 'Target',
            subject: __DIR__
        );
        $this->cleanDirectory(directory: $this->target);
    }

    #[\Override]
    public function tearDown(): void
    {
        $this->cleanDirectory(directory: $this->target);
    }

    /**
     * @return void
     */
    public function testCopy(): void
    {
        $this->folderService->copy(
            source: $this->source,
            target: $this->target
        );
        $this->verifyDirectory(source: $this->source, target: $this->target);
    }

    /**
     * @param string $source
     * @param string $target
     * @return void
     */
    private function verifyDirectory(string $source, string $target): void
    {
        $d = dir($source);
        while (($entry = $d->read()) !== false) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            if (is_dir(filename: $source . DIRECTORY_SEPARATOR . $entry)) {
                $this->assertDirectoryExists(
                    directory: $target . DIRECTORY_SEPARATOR . $entry
                );
                $this->verifyDirectory(
                    source: $source . DIRECTORY_SEPARATOR . $entry,
                    target: $target . DIRECTORY_SEPARATOR . $entry
                );
            }
            if (is_file(filename: $source . DIRECTORY_SEPARATOR . $entry)) {
                $this->assertFileExists(
                    filename: $target . DIRECTORY_SEPARATOR . $entry
                );
            }
        }
    }

    private function cleanDirectory(string $directory): void
    {
        if (!is_dir(filename: $directory)) {
            return;
        }
        $files = array_diff(scandir(directory: $directory), array('.','..'));

        foreach ($files as $file) {

            (is_dir(filename: $directory . DIRECTORY_SEPARATOR . $file)) ?
                self::cleanDirectory(
                    directory: $directory . DIRECTORY_SEPARATOR . $file)
                : unlink(filename: $directory . DIRECTORY_SEPARATOR . $file);

        }
        rmdir($directory);
    }
}