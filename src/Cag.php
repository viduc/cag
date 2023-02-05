<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag;

use Cag\Containers\DependencyInjectionInterface;
use Cag\Containers\Exceptions\DependencyInjectionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;
use Cag\UseCases\UseCaseInterface;
use Cag\UseCases\UseCaseNameExtenderAbstract;

class Cag implements UseCaseInterface
{
    /**
     * @var DependencyInjectionInterface|null
     */
    private ?DependencyInjectionInterface $dependencyInjection;
    public function __construct(
        ?DependencyInjectionInterface $dependencyInjection = null
    ) {
        $this->dependencyInjection = $dependencyInjection;
    }


    /**
     * @throws DependencyInjectionException
     * @throws NotFoundException
     */
    public function execute(
        RequestInterface $requete,
        PresenterInterface $presenter
    ): PresenterInterface {
        $useCase = $this->dependencyInjection->get(
            UseCaseNameExtenderAbstract::extend($requete->getUseCase())
        );
        return $useCase->execute($requete, $presenter);
    }
}