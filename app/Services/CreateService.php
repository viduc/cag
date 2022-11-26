<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Services;

use App\Command\CagControllerAbstract;
use App\Containers\Container;
use App\Presenters\CreateProjectPresenter;
use App\Requests\CreateRequest;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\UseCases\CreateProjectUseCase;

class CreateService extends ServiceAbstract
{
    /**
     * @param CagControllerAbstract $controller
     */
    public function __construct(CagControllerAbstract $controller)
    {
        parent::__construct(new Container($controller));
    }

    public function create(string $name, string $namespace, string $composer): void
    {
        $request = $this->container->get(CreateRequest::class);
        $request->addParam('name', $name);
        $request->addParam('nameSpacePath', $namespace);
        $request->addParam('composer', $composer);
        $presenter = $this->container->get(CreateProjectPresenter::class);
        try {
            $this->container->get(CreateProjectUseCase::class)->execute(
                $request,
                $presenter
            );
        } catch (ContainerException|NotFoundException) {

        }

    }
}
