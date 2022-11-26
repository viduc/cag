<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Loggers;

use App\Command\CagControllerAbstract;
use Cag\Constantes\LogConstantes;
use Cag\Loggers\LoggerInterface;

class LoggerCommand implements LoggerInterface
{
    private CagControllerAbstract $controller;

    /**
     * @param CagControllerAbstract $controller
     */
    public function __construct(CagControllerAbstract $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @param string   $message
     * @param string   $level
     * @param int|null $code
     *
     * @return void
     */
    public function add(
        string $message,
        string $level = LogConstantes::INFO,
        ?int $code = null
    ) {
        if ($level === LogConstantes::INFO) {
            $this->controller->getPrinter()->info($message, false);
        }
        if ($level === LogConstantes::WARNING) {
            $this->controller->getPrinter()->display($message, false);
        }
        if ($level === LogConstantes::ERROR || $level === LogConstantes::REJECT) {
            $this->controller->getPrinter()->error($message, false);
        }
        if ($level === LogConstantes::SUCCES) {
            $this->controller->getPrinter()->success($message, false);
        }
    }
}
