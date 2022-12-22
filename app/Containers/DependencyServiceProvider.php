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
            CreateService::class
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
        )->addArgument($this->getContainer());
    }
}
