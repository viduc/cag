<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Constantes;

class StructureModelConstantes
{
    const FOLDERS = [
        'Adapters',
        'Constantes',
        'Containers',
        'Exceptions',
        'Factory',
        'Loggers',
        'Models',
        'Presenters',
        'Responses',
        'Repository',
        'Requests',
        'Services',
        'UseCase',
        'Validators'
    ];

    const FILES = [
        'AdapterInterface',
        'ContainerInterface',
        'ExceptionAbstract',
        'FactoryInterface',
        'LoggerInterface',
        'ModelAbstract',
        'PresenterInterface',
        'ResponseInterface',
        'RepositoryInterface',
        'RequestInterface',
        'ServiceInterface',
        'UseCaseAbstract',
        'ValidatorInterface'
    ];

    const FILES_IN_FOLDER = [
        'AdapterInterface' => 'Adapters',
        'ContainerInterface' => 'Containers',
        'ExceptionAbstract' => 'Exceptions',
        'FactoryInterface' => 'Factory',
        'LoggerInterface' => 'Loggers',
        'ModelAbstract' => 'Models',
        'PresenterInterface' => 'Presenters',
        'ResponseInterface' => 'Responses',
        'RepositoryInterface' => 'Repository',
        'RequestInterface' => 'Requests',
        'ServiceInterface' => 'Services',
        'UseCaseAbstract' => 'UseCase',
        'ValidatorInterface' => 'Validators'
    ];
}
