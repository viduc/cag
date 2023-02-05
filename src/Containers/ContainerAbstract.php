<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

abstract class ContainerAbstract
{
    /**
     * @var DependencyInjectionInterface|null
     */
    private ?DependencyInjectionInterface $container;

    public function __construct(?DependencyInjectionInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return DependencyInjectionInterface
     */
    public function container(): DependencyInjectionInterface
    {
        if (null === $this->container) {
            $this->container = new DependencyInjection();
        }

        return $this->container;
    }

    /**
     * @param DependencyInjectionInterface|null $container
     */
    public function setContainer(?DependencyInjectionInterface $container): void
    {
        $this->container = $container;
    }
}