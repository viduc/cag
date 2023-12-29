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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateService extends ServiceAbstract
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function create(string $name, string $path, string $composer): void
    {
        $request = $this->container->get(id: CreateRequest::class);
        $request->addParam(key: 'name', value: $name);
        $request->addParam(key: 'path', value: $path);
        $request->addParam(key: 'composer', value: $composer);
        $presenter = $this->container->get(id: CreateProjectPresenter::class);
        $this->container->get(id: Cag::class)->execute(
            request: $request,
            presenter: $presenter
        );
    }
}
