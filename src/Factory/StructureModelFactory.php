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

use Cag\Constantes\StructureModelConstantes as Constantes;
use Cag\Exceptions\StructureModelException;
use Cag\Models\FolderModel;
use Cag\Models\StructureModel;

class StructureModelFactory extends FactoryAbstract
{
    /**
     * @param string      $name
     * @param string|null $nameSpace
     *
     * @return StructureModel
     */
    public function getStandard(
        string $name,
        ?string $nameSpace = ''
    ): StructureModel {
        $model = new StructureModel($name);
        $folders = [];
        $fileFactory = new FileModelFactory($this->logger);
        foreach (Constantes::FOLDERS as $folder) {
            try {
                $folders[$folder] = new FolderModel($folder);
                $model->addFolder($folders[$folder]);
            } catch (StructureModelException $exception) {
                $this->addLog(
                    $exception->getMessage(),
                    'info',
                    $exception->getCode()
                );
            }
        }
        foreach (Constantes::FILES_IN_FOLDER as
             $fileName => $folderName
        ) {
            if (!isset($folders[$folderName])) {
                $this->addLog(
                    'Le dossier '.$folderName.' pour le fichier'.
                        $fileName." n'existe pas",
                    'warning'
                );
                continue;
            }
            try {
                $file = $fileFactory->get(
                    $fileName,
                    $nameSpace,
                    $folders[$folderName]
                );
                $model->addFile($file);
            } catch (StructureModelException $exception) {
                $this->addLog(
                    $exception->getMessage(),
                    'warning',
                    $exception->getCode()
                );
            }
        }

        return $model;
    }
}
