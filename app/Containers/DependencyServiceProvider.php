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
use Cag\UseCases\CreateProjectUseCase;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DependencyServiceProvider extends AbstractServiceProvider
{
    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool
    {
        $services = [
            'createProjectPresenter',
            CreateProjectPresenter::class,
            'createRequest',
            CreateRequest::class,
            'createService',
            CreateService::class,
            'dependencyInjection',
            DependencyInjection::class,
            'createProjectUseCase',
            CreateProjectUseCase::class
        ];

        return in_array($id, $services);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->getContainer()->add(
            'createProjectPresenter',
            CreateProjectPresenter::class
        );
        $this->getContainer()->add(
            'createRequest',
            CreateRequest::class
        );
        $this->getContainer()->add(
            'createService',
            CreateService::class
        )->addArgument('dependencyInjection');
        $this->getContainer()->add(
            'dependencyInjection',
            DependencyInjection::class
        );
        $this->getContainer()->add(
            'createProjectUseCase',
            CreateProjectUseCase::class
        )->addArgument('dependencyInjection');
    }
}
