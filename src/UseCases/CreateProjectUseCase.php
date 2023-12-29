<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\UseCases;

use Cag\Exceptions\ExceptionAbstract;
use Cag\Factory\Model\ErreurModelFactoryAbstract;
use Cag\Factory\Model\StructureModelFactoryAbstract;
use Cag\Factory\Response\CreateProjectResponseFactoryAbstract;
use Cag\Models\ErrorModel;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;
use Cag\Responses\ResponseInterface;
use Cag\Services\ComposerServiceAbstract;
use Cag\Services\StructureServiceAbstract;

class CreateProjectUseCase implements UseCaseInterface
{
    private RequestInterface $request;

    private ResponseInterface $response;

    /**
     * array.
     */
    private const DEFAULT_PARAMS = [
        'name' => 'project',
        'composer' => 'true',
        'path' => '',
    ];

    public function __construct(
        private readonly StructureServiceAbstract $structureService,
        private readonly ComposerServiceAbstract $composerService,
        private readonly StructureModelFactoryAbstract $structureModelFactory,
        private readonly CreateProjectResponseFactoryAbstract $createProjectResponseFactory
    ) {
        $this->response = $this->createProjectResponseFactory->createResponse();
    }

    public function execute(
        RequestInterface $request,
        PresenterInterface $presenter
    ): PresenterInterface {
        $this->request = $request;
        try {
            $model = $this->structureModelFactory->getStandard(
                name: $this->getParam(param: 'name'),
                path: $this->getParam(param: 'path')
            );
            $this->structureService->create(model: $model);
            if ('true' === $this->getParam(param: 'composer')) {
                $this->composerService->addAutoload(
                    key: $this->getParam(param: 'name').'\\',
                    value: [$this->getParam(param: 'path')]
                );
            }
            $this->response->setStructureModel(model: $model);
        } catch (ExceptionAbstract $e) {
            $this->response->setError(erreur: new ErrorModel(
                code: $e->getCode(),
                message: $e->getMessage()
            ));
        }
        $presenter->presente(reponse: $this->response);

        return $presenter;
    }

    private function getParam(string $param): string
    {
        try {
            $value = $this->request->getParam(param: $param) ?? '';
        } catch (ExceptionAbstract) {
            $erreur = ErreurModelFactoryAbstract::get();
            $erreur->setMessage(message: 'Param '.$param.' not found in request');
            $this->response->setError(erreur: $erreur);
            $value = '';
        }

        return '' === $value ? self::DEFAULT_PARAMS[$param] : $value;
    }
}
