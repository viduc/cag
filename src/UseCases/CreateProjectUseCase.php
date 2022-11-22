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

use Cag\Constantes\LogConstantes;
use Cag\Containers\Container;
use Cag\Containers\ContainerInterface;
use Cag\Exceptions\ExceptionAbstract;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Factory\StructureModelFactory;
use Cag\Loggers\LoggerInterface;
use Cag\Models\ErreurModel;
use Cag\Presenters\PresenterInterface;
use Cag\Responses\CreateProjectResponse;
use Cag\Requests\RequestInterface;
use Cag\Services\ComposerService;
use Cag\Services\StructureService;

class CreateProjectUseCase extends UseCaseAbstract
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
    private StructureModelFactory $factory;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;


    /**
     * @param ContainerInterface $container
     *
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct(new Container($container));
        $this->structureService = $this->container()->get(
            StructureService::class
        );
        $this->composerService = $this->container()->get(
            ComposerService::class
        );
        $this->factory = $this->container()->get(StructureModelFactory::class);
        $this->logger = $this->container()->get(LoggerInterface::class);
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
        $reponse = new CreateProjectResponse();
        try {
            $model = $this->factory->getStandard(
                $this->getParam('name')
            );
            $this->structureService->create($model);
            if ($this->getParam('composer') === 'true') {
                $this->composerService->addAutoload(
                    $this->getParam('nameSpace').'\\',
                    [$this->getParam('nameSpacePath')]
                );
            }
            $reponse->setStructureModel($model);
        } catch (ExceptionAbstract $e) {
            $reponse->setErreur(new ErreurModel(
                $e->getCode(),
                $e->getMessage()
            ));
        }
        $presenter->presente($reponse);

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
            $this->logger->add(
                "Param ".$param." not found in request",
                LogConstantes::WARNING
            );
            $value = '';
        }
        if ('' === $value) {
            if ($param === 'name') {
                $value = 'project';
            }
            if ($param === 'composer') {
                $value = 'true';
            }
        }

        return $value;
    }
}
