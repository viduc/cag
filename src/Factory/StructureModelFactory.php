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
use Cag\Loggers\LoggerInterface;
use Cag\Models\FileModel;
use Cag\Models\FolderModel;
use Cag\Models\StructureModel;

class StructureModelFactory implements FactoryInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $name
     *
     * @return StructureModel
     */
    public function getStandard(string $name): StructureModel
    {
        $model = new StructureModel($name);
        $folders = [];
        foreach (Constantes::FOLDERS as $folder) {
            try {
                $folders[$folder] = new FolderModel($folder);
                $model->addFolder($folders[$folder]);
            } catch (StructureModelException $exception) {
                $this->logger->add(
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
                $this->logger->add(
                    'Le dossier '.$folderName.' pour le fichier'.
                        $fileName." n'existe pas",
                    'warning'
                );
                continue;
            }
            try {
                $file = new FileModel($fileName);
                $file->setParent($folders[$folderName]);
                $model->addFile($file);
            } catch (StructureModelException $exception) {
                $this->logger->add(
                    $exception->getMessage(),
                    'warning',
                    $exception->getCode()
                );
            }
        }

        return $model;
    }
}
