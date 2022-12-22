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

use App\Presenters\CreateProjectPresenter;
use App\Requests\CreateRequest;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\UseCases\CreateProjectUseCase;

class CreateService extends ServiceAbstract
{
    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function create(string $name, string $path, string $composer): void
    {
        $request = $this->container->get('createRequest');
        $request->addParam('name', $name);
        $request->addParam('path', $path);
        $request->addParam('composer', $composer);
        $presenter = $this->container->get('createProjectPresenter');
        $this->container->get('createProjectUseCase')->execute(
            $request,
            $presenter
        );
    }
}
