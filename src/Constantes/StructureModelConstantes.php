<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Constantes;

class StructureModelConstantes
{
    public const FOLDERS = [
        'Adapters',
        'Constantes',
        'Containers',
        'Exceptions',
        'Factory',
        'Factory'.DIRECTORY_SEPARATOR.'Model',
        'Models',
        'Presenters',
        'Responses',
        'Repository',
        'Requests',
        'Services',
        'UseCase',
        'Validators',
    ];

    public const FILES_IN_FOLDER = [
        'AdapterInterface.php' => 'Adapters',
        'ContainerInterface.php' => 'Containers',
        'ExceptionAbstract.php' => 'Exceptions',
        'FactoryInterface.php' => 'Factory',
        'ModelInterface.php' => 'Factory'.DIRECTORY_SEPARATOR.'Model',
        'ModelAbstract.php' => 'Models',
        'PresenterInterface.php' => 'Presenters',
        'ResponseInterface.php' => 'Responses',
        'RepositoryInterface.php' => 'Repository',
        'RequestInterface.php' => 'Requests',
        'ServiceInterface.php' => 'Services',
        'UseCaseInterface.php' => 'UseCase',
        'ValidatorInterface.php' => 'Validators',
    ];

    public const FILES_CONTENT = '<?php'.PHP_EOL.PHP_EOL.'namespace %s'.PHP_EOL.
        PHP_EOL.'%s %s'.PHP_EOL.'{'.PHP_EOL.'}'.PHP_EOL;
}
