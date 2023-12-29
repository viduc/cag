<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

abstract class ContainerAbstract
{
    public function __construct(private DependencyInjectionInterface|null $container = null)
    {
    }

    public function container(): DependencyInjectionInterface
    {
        if (null === $this->container) {
            $this->container = new DependencyInjection();
        }

        return $this->container;
    }
}
