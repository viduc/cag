<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory\Model;

use Cag\Models\FileModel;
use Cag\Models\FolderModel;

abstract class FileModelFactoryAbstract implements ModelFactoryInterface
{
    /**
     * @param string $name
     * @param string|null $nameSpace
     * @param FolderModel|null $folder
     * @return FileModel
     */
    public abstract function getStandard(
        string $name,
        ?string $nameSpace = '',
        ?FolderModel $folder = null
    ): FileModel;
}