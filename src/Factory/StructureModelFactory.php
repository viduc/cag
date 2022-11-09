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
use Cag\Models\FolderModel;
use Cag\Models\StructureModel;

class StructureModelFactory extends AbstractFactory
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
        foreach (Constantes::FOLDERS as $folder) {
            try {
                $model->addFolder(new FolderModel($folder));
            } catch (StructureModelException $exception) {
                $this->logger->add(
                    $exception->getMessage(),
                    'info',
                    $exception->getCode()
                );
            }
        }

        return $model;
    }
}
