<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Controller;

use Cag\DependencyInjection\ContainerInterface;
use Cag\Factory\DependencyInjectionAbstract;
use Cag\Presenter\PresenterInterface;
use Cag\Requete\RequeteInterface;

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
     * @param RequeteInterface $requete
     * @param PresenterInterface $presenter
     * @return PresenterInterface
     */
    abstract public function execute(
        RequeteInterface $requete,
        PresenterInterface $presenter
    ): PresenterInterface;
}