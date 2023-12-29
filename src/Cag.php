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

use Cag\Containers\DependencyInjection;
use Cag\Containers\DependencyInjectionInterface;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Exceptions\DependencyInjectionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;
use Cag\UseCases\UseCaseInterface;
use Cag\UseCases\UseCaseNameExtenderAbstract;
use ReflectionException;

class Cag implements UseCaseInterface
{
    /**
     * @var DependencyInjectionInterface
     */
    private DependencyInjectionInterface $dependencyInjection;

    /**
     * @throws ComposerException
     * @throws DefinitionException
     * @throws ReflectionException
     * @throws NotFoundException
     */
    public function __construct(
        DependencyInjectionInterface|null $externalDependencyInjection = null
    ) {
        $this->dependencyInjection = new DependencyInjection(
            container: $externalDependencyInjection
        );
    }


    /**
     * @param RequestInterface $request
     * @param PresenterInterface $presenter
     * @return PresenterInterface
     * @throws DefinitionException
     * @throws DependencyInjectionException
     * @throws NotFoundException
     * @throws ReflectionException
     */
    public function execute(
        RequestInterface   $request,
        PresenterInterface $presenter
    ): PresenterInterface {
        $useCase = $this->dependencyInjection->get(
            id: UseCaseNameExtenderAbstract::extend(
                useCase: $request->getUseCase()
            )
        );

        return $useCase->execute(requete: $request, presenter: $presenter);
    }
}