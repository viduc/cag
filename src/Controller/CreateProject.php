<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Controller;

use Cag\Model\StructureModel;
use Cag\Presenter\PresenterInterface;
use Cag\Reponse\CreateProjectReponse;
use Cag\Requete\RequeteInterface;

class CreateProject extends UseCaseAbstract
{
    public function execute(
        RequeteInterface $requete,
        PresenterInterface $presenter
    ): PresenterInterface
    {
        $reponse = new CreateProjectReponse();
        $model = new StructureModel();
        $reponse->setStructureModel($model);
        $presenter->presente($reponse);
        return $presenter;
    }
}
