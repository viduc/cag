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
use Cag\Factory\Model\ErreurModelFactory;
use Cag\Factory\Model\StructureModelFactory;
use Cag\Factory\Response\CreateProjectResponseFactory;
use Cag\Models\ErrorModel;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;
use Cag\Responses\ResponseInterface;
use Cag\Services\ComposerService;
use Cag\Services\StructureService;

class CreateProjectUseCase implements UseCaseInterface
{
    /**
     * @var StructureService
     */
    private StructureService $structureService;

    /**
     * @var ComposerService
     */
    private ComposerService $composerService;

    /**
     * @var StructureModelFactory
     */
    private StructureModelFactory $structureModelFactory;

    /**
     * @var CreateProjectResponseFactory|mixed
     */
    private CreateProjectResponseFactory $createProjectResponseFactory;

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
     * @param StructureService $structureService
     * @param ComposerService $composerService
     * @param StructureModelFactory $structureModelFactory
     * @param CreateProjectResponseFactory $createProjectResponseFactory
     */
    public function __construct(
        StructureService $structureService,
        ComposerService $composerService,
        StructureModelFactory $structureModelFactory,
        CreateProjectResponseFactory $createProjectResponseFactory
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
            $this->response->setErreur(new ErrorModel(
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
            $erreur = ErreurModelFactory::get();
            $erreur->setMessage("Param ".$param." not found in request");
            $this->response->setErreur($erreur);
            $value = '';
        }

        return '' === $value ? self::DEFAULT_PARAMS[$param] : $value;
    }
}
