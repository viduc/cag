<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Command;

use App\Containers\DependencyInjection;
use Minicli\Command\CommandController;
use Minicli\Output\OutputHandler;

abstract class CagControllerAbstract extends CommandController
{
    /**
     * @var DependencyInjection
     */
    public DependencyInjection $container;

    public function __construct()
    {
        $this->container = new DependencyInjection();
    }

    /**
     * @return void
     */
    #[\Override]
    abstract public function handle(): void;

    /**
     * @return OutputHandler
     */
    #[\Override]
    public function getPrinter(): OutputHandler
    {
        return parent::getPrinter();
    }
}