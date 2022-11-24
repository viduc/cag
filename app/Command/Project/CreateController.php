<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Command\Project;

use Minicli\Command\CommandController;
use Minicli\Input;

class CreateController extends CommandController
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->getPrinter()->info(
            'Create new Clean Architecture project',
            true
        );
        $this->getPrinter()->newline();
        $this->getPrinter()->display(
            'fill in the name of your application'
        );
        $input = new Input('Name > ');
        $name = $input->read();

        $this->getPrinter()->display(
            'enter the relative path of your project folder (ex: src or src\domain)'
        );
        $input = new Input('path > ');
        $path = $input->read();

        $this->getPrinter()->display(
            'want to add your application to composer autoload? (Y/n)'
        );
        $autoload = null;
        while ($autoload === null) {
            $input = new Input('Add autoload (Y/n) > ');
            $autoload = $input->read();
            $autoload = $autoload === '' ? 'y' : $autoload;
            $autoload = in_array(strtolower($autoload), ['y', 'n']) ?
                (strtolower($autoload) === 'y' ? 'true' : 'false') : null;
        }
        $this->getPrinter()->info(
            sprintf(
                'A new project will be created with the following parameters:
                    application name: %s
                    path: %s
                    composer add autoload: %s',
                $name,
                $path,
                $autoload
            )
        );
        $this->getPrinter()->display(
            'Do you want to create the project? (Y/n)'
        );
        $create = null;
        while ($create === null) {
            $input = new Input('Create? (Y/n) > ');
            $create = $input->read();
            $create = $create === '' ? 'y' : $create;
            $create = in_array(strtolower($create), ['y', 'n']) ?
                strtolower($create) === 'y' : null;

        }
        if ($create) {
            //TODO create structure
        }
    }
}
