<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Controllers;

use Cag\Exceptions\AbstractException;
use Cag\Models\ErreurModel;
use Cag\Models\StructureModel;
use Cag\Presenters\PresenterInterface;
use Cag\Responses\CreateProjectResponse;
use Cag\Requests\RequestInterface;

class CreateProject extends UseCaseAbstract
{
    public function execute(
        RequestInterface   $request,
        PresenterInterface $presenter
    ): PresenterInterface {
        $reponse = new CreateProjectResponse();
        try {
            $model = new StructureModel($request->getParam('name'));
            $reponse->setStructureModel($model);
        } catch (AbstractException $e) {
            $reponse->setErreur(new ErreurModel(
                $e->getCode(),
                $e->getMessage()
            ));
        }
        $presenter->presente($reponse);

        return $presenter;
    }
}
