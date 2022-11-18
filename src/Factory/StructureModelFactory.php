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

use Cag\Constantes\LogConstantes;
use Cag\Constantes\StructureModelConstantes as Constantes;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Exceptions\StructureModelException;
use Cag\Loggers\LoggerInterface;
use Cag\Models\FolderModel;
use Cag\Models\StructureModel;
use Exception;

class StructureModelFactory extends FactoryAbstract
{
    /**
     * @var StructureModel
     */
    private StructureModel $sturctureModel;

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
        $this->sturctureModel = new StructureModel($name);
        $folders = [];
        $this->addStandardFolder($folders);
        $this->addStandardFile($folders, $nameSpace);

        return $this->sturctureModel;
    }

    /**
     * @param array $folders
     *
     * @return void
     */
    private function addStandardFolder(array &$folders): void
    {
        foreach (Constantes::FOLDERS as $folder) {
            try {
                $folders[$folder] = new FolderModel($folder);
                $this->sturctureModel->addFolder($folders[$folder]);
            } catch (StructureModelException $exception) {
                $this->addLog(
                    $exception->getMessage(),
                    LogConstantes::INFO,
                    $exception->getCode()
                );
            }
        }
    }

    /**
     * @param array  $folders
     * @param string $nameSpace
     *
     * @return void
     */
    private function addStandardFile(array $folders, string $nameSpace): void
    {
        foreach (Constantes::FILES_IN_FOLDER as $fileName => $folderName) {
            if (!isset($folders[$folderName])) {
                $this->addLog(
                    'Le dossier '.$folderName.' pour le fichier'.
                    $fileName." n'existe pas",
                    LogConstantes::WARNING
                );
                continue;
            }
            try {
                $file = $this->container()->get(
                    FileModelFactory::class
                )->getStandard(
                    $fileName,
                    $nameSpace,
                    $folders[$folderName]
                );
                $this->sturctureModel->addFile($file);
            } catch (Exception $exception) {
                $this->addLog(
                    $exception->getMessage(),
                    LogConstantes::WARNING,
                    $exception->getCode()
                );
            }
        }
    }
}
