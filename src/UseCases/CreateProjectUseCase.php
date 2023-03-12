<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
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
use Cag\Services\ComposerService;
use Cag\Services\ComposerServiceAbstract;
use Cag\Services\StructureService;
use Cag\Services\StructureServiceAbstract;

class CreateProjectUseCase implements UseCaseInterface
{
    /**
     * @var StructureService
     */
    private StructureServiceAbstract $structureService;

    /**
     * @var ComposerService
     */
    private ComposerServiceAbstract $composerService;

    /**
     * @var StructureModelFactoryAbstract
     */
    private StructureModelFactoryAbstract $structureModelFactory;

    /**
     * @var CreateProjectResponseFactoryAbstract
     */
    private CreateProjectResponseFactoryAbstract $createProjectResponseFactory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * array
     */
    private const DEFAULT_PARAMS = [
        'name' => 'project',
        'composer' => 'true',
        'path' => ''
    ];

    /**
     * @param StructureServiceAbstract $structureService
     * @param ComposerServiceAbstract $composerService
     * @param StructureModelFactoryAbstract $structureModelFactory
     * @param CreateProjectResponseFactoryAbstract $createProjectResponseFactory
     */
    public function __construct(
        StructureServiceAbstract $structureService,
        ComposerServiceAbstract $composerService,
        StructureModelFactoryAbstract $structureModelFactory,
        CreateProjectResponseFactoryAbstract $createProjectResponseFactory
    ) {
        $this->structureService = $structureService;
        $this->composerService = $composerService;
        $this->structureModelFactory = $structureModelFactory;
        $this->createProjectResponseFactory = $createProjectResponseFactory;
        $this->response = $this->createProjectResponseFactory->createResponse();
    }

    /**
     * @param RequestInterface   $request
     * @param PresenterInterface $presenter
     *
     * @return PresenterInterface
     */
    public function execute(
        RequestInterface   $request,
        PresenterInterface $presenter
    ): PresenterInterface {
        $this->request = $request;
        try {
            $model = $this->structureModelFactory->getStandard(
                $this->getParam('name'),
                $this->getParam('path')
            );
            $this->structureService->create($model);
            if ($this->getParam('composer') === 'true') {
                $this->composerService->addAutoload(
                    $this->getParam('name').'\\',
                    [$this->getParam('path')]
                );
            }
            $this->response->setStructureModel($model);
        } catch (ExceptionAbstract $e) {
            $this->response->setError(new ErrorModel(
                $e->getCode(),
                $e->getMessage()
            ));
        }
        $presenter->presente($this->response);

        return $presenter;
    }

    /**
     * @param string $param
     *
     * @return string
     */
    private function getParam(string $param): string
    {
        try {
            $value = $this->request->getParam($param) ?? '';
        } catch (ExceptionAbstract $e) {
            $erreur = ErreurModelFactoryAbstract::get();
            $erreur->setMessage("Param ".$param." not found in request");
            $this->response->setError($erreur);
            $value = '';
        }

        return '' === $value ? self::DEFAULT_PARAMS[$param] : $value;
    }
}
