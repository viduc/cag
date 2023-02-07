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
use Cag\Cag;
use Cag\Exceptions\ContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateService extends ServiceAbstract
{
    /**
     * @throws ContainerException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function create(string $name, string $path, string $composer): void
    {
        $request = $this->container->get(CreateRequest::class);
        $request->addParam('name', $name);
        $request->addParam('path', $path);
        $request->addParam('composer', $composer);
        $presenter = $this->container->get(CreateProjectPresenter::class);
        $this->container->get(Cag::class)->execute(
            $request,
            $presenter
        );
    }
}
