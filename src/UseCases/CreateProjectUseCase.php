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

use Cag\Containers\ContainerInterface;
use Cag\Exceptions\ExceptionAbstract;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Factory\StructureModelFactory;
use Cag\Models\ErreurModel;
use Cag\Presenters\PresenterInterface;
use Cag\Responses\CreateProjectResponse;
use Cag\Requests\RequestInterface;
use Cag\Services\StructureService;

class CreateProjectUseCase extends UseCaseAbstract
{
    /**
     * @var StructureService
     */
    private StructureService $structureService;

    /**
     * @var StructureModelFactory
     */
    private StructureModelFactory $factory;

    /**
     * @param ContainerInterface $container
     *
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->structureService = new StructureService();
        $this->factory = new StructureModelFactory(
            $this->container->get('logger')
        );
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
        $reponse = new CreateProjectResponse();
        try {
            $model = $this->factory->getStandard(
                $request->getParam('name')
            );
            $this->structureService->create($model);
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
}
