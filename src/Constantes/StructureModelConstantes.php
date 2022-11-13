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

    const FILES_IN_FOLDER = [
        'AdapterInterface.php' => 'Adapters',
        'ContainerInterface.php' => 'Containers',
        'ExceptionAbstract.php' => 'Exceptions',
        'FactoryAbstract.php' => 'Factory',
        'LoggerInterface.php' => 'Loggers',
        'ModelAbstract.php' => 'Models',
        'PresenterInterface.php' => 'Presenters',
        'ResponseInterface.php' => 'Responses',
        'RepositoryInterface.php' => 'Repository',
        'RequestInterface>.php' => 'Requests',
        'ServiceInterface.php' => 'Services',
        'UseCaseAbstract.php' => 'UseCase',
        'ValidatorInterface.php' => 'Validators'
    ];

    const FILES_CONTENT = '<?php'.PHP_EOL.PHP_EOL.'namespace %s'.PHP_EOL.
        PHP_EOL.'%s %s'.PHP_EOL.'{'.PHP_EOL.'}'.PHP_EOL;
}
