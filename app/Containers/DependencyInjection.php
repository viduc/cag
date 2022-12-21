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
use DI\Container;

class DependencyInjection implements ContainerInterface
{
    /**
     * @var Container
     */
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function get(string $id): mixed
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
