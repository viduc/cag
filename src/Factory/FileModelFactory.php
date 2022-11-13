<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory;

use Cag\Models\FileModel;
use Cag\Models\FolderModel;

class FileModelFactory extends FactoryAbstract
{
    public function get(
        string $name,
        ?string $nameSpace = '',
        ?FolderModel $folder = null
    ): FileModel {
        $model = new FileModel($name, $nameSpace);
        if (null !== $folder) {
            $model->setParent($folder);
        }
        return $model;
    }
}
