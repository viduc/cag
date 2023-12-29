<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Responses;

use Cag\Models\ErrorModel;
use Cag\Models\StructureModel;

class CreateProjectResponse extends CreateProjectResponseAbstract
{
    private ErrorModel $erreur;

    private StructureModel $model;

    #[\Override]
    public function setStructureModel(StructureModel $model): void
    {
        $this->model = $model;
    }

    #[\Override]
    public function setError(ErrorModel $erreur): void
    {
        $this->erreur = $erreur;
    }

    #[\Override]
    public function getError(): ErrorModel
    {
        $this->erreur = $this->erreur ?? new ErrorModel();

        return $this->erreur;
    }
}
