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

use Cag\Constantes\StructureModelConstantes;
use Cag\Models\FileModel;
use Cag\Models\FolderModel;

class FileModelFactory extends FileModelFactoryAbstract
{
    /**
     * @param string           $name
     * @param string|null      $nameSpace
     * @param FolderModel|null $folder
     *
     * @return FileModel
     */
    public function getStandard(
        string $name,
        ?string $nameSpace = '',
        ?FolderModel $folder = null
    ): FileModel {
        $model = new FileModel($name, $nameSpace);
        if (null !== $folder) {
            $model->setParent($folder);
        }

        $model->setContent(
            sprintf(
                StructureModelConstantes::FILES_CONTENT,
                $model->getNameSpace().';',
                $model->getType(),
                str_replace('.php', '', $model->getName())
            )
        );

        return $model;
    }
}
