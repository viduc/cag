<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Loggers;

use Cag\Constantes\LogConstantes;

interface LoggerInterface
{
    public function add(
        string $message,
        string $level = LogConstantes::INFO,
        ?int $code = null
    );
}