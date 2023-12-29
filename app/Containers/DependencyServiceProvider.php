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
use Cag\Cag;
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
         'cag',
        Cag::class
    ];
    /**
     * @param string $id
     *
     * @return bool
     */
    #[\Override]
    public function provides(string $id): bool
    {
        return in_array(needle: $id, haystack: self::SERVICES);
    }

    /**
     * @return void
     */
    #[\Override]
    public function register(): void
    {
        $this->getContainer()->add(id: DependencyInjection::class);
        $this->getContainer()->add(id: CreateProjectPresenter::class);
        $this->getContainer()->add(id: CreateRequest::class);
        $this->getContainer()
            ->add(id: CreateService::class)
            ->addArgument(arg: DependencyInjection::class);
        $this->getContainer()
            ->add(id: Cag::class)
            ->addArgument(arg: DependencyInjection::class);
    }
}
