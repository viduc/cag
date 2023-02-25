<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Containers;

use App\Presenters\CreateProjectPresenter;
use App\Requests\CreateRequest;
use App\Services\CreateService;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DependencyServiceProvider extends AbstractServiceProvider
{
     const SERVICES = [
        'createProjectPresenter',
        CreateProjectPresenter::class,
        'createRequest',
        CreateRequest::class,
        'createService',
        CreateService::class,
        'dependencyInjection',
        DependencyInjection::class,
    ];
    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool
    {


        return in_array($id, self::SERVICES);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->getContainer()->add(DependencyInjection::class);
        $this->getContainer()->add(CreateProjectPresenter::class);
        $this->getContainer()->add(CreateRequest::class);
        $this->getContainer()
            ->add(CreateService::class)
            ->addArgument(DependencyInjection::class);
    }
}
