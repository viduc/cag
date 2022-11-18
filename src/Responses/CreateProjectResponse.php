<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Responses;

use Cag\Models\ErreurModel;
use Cag\Models\StructureModel;

class CreateProjectResponse extends ResponseAbstract
{
    private ErreurModel $erreur;

    private StructureModel $model;

    /**
     * @inheritDoc
     */
    public function setErreur(ErreurModel $erreur): void
    {
        $this->erreur = $erreur;
    }

    /**
     * @inheritDoc
     */
    public function getErreur(): ErreurModel
    {
        $this->erreur = $this->erreur ?? new ErreurModel();

        return $this->erreur;
    }

    public function getStructureModel(): StructureModel
    {
        return $this->model;
    }

    public function setStructureModel(StructureModel $model): void
    {
        $this->model = $model;
    }
}