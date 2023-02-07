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

use Cag\Constantes\LogConstantes;
use Cag\Constantes\StructureModelConstantes as Constantes;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Exceptions\StructureModelException;
use Cag\Factory\FactoryAbstract;
use Cag\Models\FolderModel;
use Cag\Models\StructureModel;
use Exception;

class StructureModelFactory extends FactoryAbstract
{
    private FolderModelFactory $folderModelFactory;
    private FileModelFactory $fileModelFactory;

    public function __construct(
        FileModelFactory $fileModelFactory,
        FolderModelFactory $folderModelFactory
    ) {
        $this->folderModelFactory = $folderModelFactory;
        $this->fileModelFactory = $fileModelFactory;
    }
    /**
     * @var StructureModel
     */
    private StructureModel $sturctureModel;

    /**
     * @var string
     */
    private string $nameSpace = '';

    /**
     * @var FolderModel[]
     */
    private array $folders = [];

    /**
     * @param string      $name
     * @param string|null $path
     *
     * @return StructureModel
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function getStandard(
        string $name,
        ?string $path = 'src'
    ): StructureModel {
        $this->sturctureModel = new StructureModel($name, $path);
        $this->nameSpace = $this->sturctureModel->getSrcName();
        $this->addStandardFolder();
        $this->addStandardFile();

        return $this->sturctureModel;
    }

    /**
     * @return void
     */
    private function addStandardFolder(): void
    {
        foreach (Constantes::FOLDERS as $folder) {
            try {
                $this->folders[$folder] = $this->folderModelFactory->getStandard(
                    $folder
                );
                $this->sturctureModel->addFolder($this->folders[$folder]);
            } catch (StructureModelException $exception) {
                //TODO revoir remplacement log
            }
        }
    }

    /**
     * @return void
     */
    private function addStandardFile(): void
    {
        foreach (Constantes::FILES_IN_FOLDER as $fileName => $folderName) {
            if (!isset($this->folders[$folderName])) {
                //TODO revoir remplacement log
                continue;
            }
            $this->getStandardFile($fileName, $this->folders[$folderName]);
        }
    }

    /**
     * @param string      $fileName
     * @param FolderModel $folder
     *
     * @return void
     */
    private function getStandardFile(string $fileName, FolderModel $folder): void
    {
        try {
            $this->sturctureModel->addFile(
                $this->fileModelFactory->getStandard(
                    $fileName,
                    $this->nameSpace,
                    $folder
                )
            );
        } catch (Exception $exception) {
            //TODO revoir remplacement log
        }
    }
}
