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

use App\Command\CagControllerAbstract;
use App\Loggers\LoggerCommand;
use App\Presenters\CreateProjectPresenter;
use App\Requests\CreateRequest;
use App\Services\CreateService;
use Cag\Containers\ContainerInterface;
use Cag\Exceptions\NotFoundException;
use Cag\Loggers\LoggerInterface;
use Cag\UseCases\CreateProjectUseCase;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    const LIST_INTERFACE = [
        LoggerInterface::class
    ];
    const LIST_CLASS = [
        CreateProjectUseCase::class,
        CreateRequest::class,
        CreateProjectPresenter::class,
        CreateService::class
    ];

    /**
     * @var CagControllerAbstract
     */
    private CagControllerAbstract $controller;

    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * @param CagControllerAbstract $controller
     */
    public function __construct(CagControllerAbstract $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @inheritDoc
     */
    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            if ($this->reflection->getName() === LoggerInterface::class) {
                return new LoggerCommand($this->controller);
            }
            if ($this->reflection->getName() === CreateProjectUseCase::class) {
                return new CreateProjectUseCase($this);
            }
            if ($this->reflection->getName() === CreateRequest::class) {
                return new CreateRequest();
            }
            if ($this->reflection->getName() === CreateProjectPresenter::class) {
                return new CreateProjectPresenter();
            }
            if ($this->reflection->getName() === CreateService::class) {
                return new CreateService($this->controller);
            }
        }
        throw new NotFoundException(
            "No entry was found for ".$id." identifier"
        );
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        try {
            $this->reflection = new ReflectionClass($id);
            if ($this->reflection->isInterface()) {
                return in_array(
                    $this->reflection->getName(),
                    self::LIST_INTERFACE
                );
            }
            if ($this->reflection->isInstantiable()) {
                return in_array(
                    $this->reflection->getName(),
                    self::LIST_CLASS
                );
            }
            return false;
        } catch (ReflectionException $e) {
            return false;
        }
    }
}