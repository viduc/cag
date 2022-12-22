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

use Cag\Containers\ContainerInterface;
use League\Container\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DependencyInjection implements ContainerInterface
{
    /**
     * @var Container
     */
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->container->addServiceProvider(new DependencyServiceProvider());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): mixed
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
