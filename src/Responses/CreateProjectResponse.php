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

use Cag\Models\ErrorModel;
use Cag\Models\StructureModel;

class CreateProjectResponse extends ResponseAbstract
{
    private ErrorModel $erreur;

    private StructureModel $model;

    public function getStructureModel(): StructureModel
    {
        return $this->model;
    }

    public function setStructureModel(StructureModel $model): void
    {
        $this->model = $model;
    }

    public function setError(ErrorModel $erreur): void
    {
        $this->erreur = $erreur;
    }

    public function getError(): ErrorModel
    {
        $this->erreur = $this->erreur ?? new ErrorModel();

        return $this->erreur;
    }
}