<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory;

use Cag\Containers\ContainerAbstract;
use Cag\Constantes\LogConstantes;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;

abstract class FactoryAbstract extends ContainerAbstract
{
    /**
     * @param string $message
     * @param string $level
     * @param int    $code
     *
     * @return void
     */
    protected function addLog(
        string $message,
        string $level = LogConstantes::INFO,
        int $code = 0
    ): void {
        try {
            $this->container()->get('Logger')?->add($message, $level, $code);
        } catch (NotFoundException|ContainerException) {
            echo "No Logger found";
        }

    }
}
