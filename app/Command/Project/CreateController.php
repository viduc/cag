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

use App\Command\CagControllerAbstract;
use App\Services\CreateService;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Minicli\Input;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateController extends CagControllerAbstract
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $path;

    /**
     * @var string
     */
    private string $autoload;

    /**
     * @return void
     * @throws ContainerException
     * @throws ContainerExceptionInterface
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     */
    public function handle(): void
    {
        $this->getPrinter()->info(
            'Create new Clean Architecture project',
            true
        );
        $this->getPrinter()->newline();
        $this->askName();
        $this->askPath();
        $this->askAutoload();
        $this->getPrinter()->info(
            sprintf(
                'A new project will be created with the following '.
                'parameters:
            application name: %s
            path: %s
            composer add autoload: %s',
                $this->name,
                $this->path,
                $this->autoload
            )
        );
        $this->askValidation();
    }

    /**
     * @return void
     */
    private function askName(): void
    {
        $this->name = $this->getInputString(
            'name',
            'fill in the name of your application (will use as namespace)'
        );
    }

    /**
     * @return void
     */
    private function askPath(): void
    {
        $this->path = $this->getInputString(
            'path',
            'enter the relative path of your project folder (ex: src or'.
            'src\domain)'
        );
    }

    /**
     * @return void
     */
    private function askAutoload(): void
    {
        $this->autoload = $this->getInputYesOrNo(
            'Add autoload',
            'want to add your application to composer autoload? (Y/n)'
        ) ? 'true' : 'false';
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    private function askValidation(): void
    {
        if ($this->getInputYesOrNo(
            'Create',
            'Do you want to create the project? (Y/n)'
        )) {
            $this->container->get(CreateService::class)->create(
                $this->name,
                $this->path,
                $this->autoload
            );
        }
    }

    /**
     * @param string $identifier
     * @param string $display
     *
     * @return string
     */
    private function getInputString(
        string $identifier,
        string $display = ''
    ): string {
        if ('' !== $display) {
            $this->getPrinter()->display($display);
        }
        $value = '';
        while ('' === $value) {
            $input = new Input($identifier.' > ');
            $value = $input->read();
        }

        return $value;
    }

    /**
     * @param string $identifier
     * @param string $display
     *
     * @return bool
     */
    private function getInputYesOrNo(
        string $identifier,
        string $display = ''
    ): bool {
        $this->getPrinter()->display($display);
        $value = null;
        while ($value === null) {
            $input = new Input($identifier.'? (Y/n) > ');
            $value = $input->read();
            $value = $value === '' ? 'y' : $value;
            $value = in_array(strtolower($value), ['y', 'n']) ?
                strtolower($value) === 'y' : null;
        }

        return $value == 'y';
    }
}
