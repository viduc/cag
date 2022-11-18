<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\UseCases;

use Cag\Containers\ContainerAbstract;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;

abstract class UseCaseAbstract extends ContainerAbstract
{
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
