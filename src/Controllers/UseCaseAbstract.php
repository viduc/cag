<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Controllers;

use Cag\Containers\ContainerInterface;
use Cag\Factory\DependencyInjectionAbstract;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;

abstract class UseCaseAbstract
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ContainerInterface $container
     * @return void
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @param RequestInterface   $requete
     * @param PresenterInterface $presenter
     *
     * @return PresenterInterface
     */
    abstract public function execute(
        RequestInterface   $requete,
        PresenterInterface $presenter
    ): PresenterInterface;
}