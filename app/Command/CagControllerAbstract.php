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

use App\Containers\Container;
use Cag\Containers\ContainerInterface;
use Minicli\Command\CommandController;
use Minicli\Output\OutputHandler;

abstract class CagControllerAbstract extends CommandController
{
    /**
     * @var ContainerInterface
     */
    public ContainerInterface $container;

    public function __construct()
    {
        $this->container = new Container($this);
    }

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @return OutputHandler
     */
    public function getPrinter(): OutputHandler
    {
        return parent::getPrinter();
    }
}