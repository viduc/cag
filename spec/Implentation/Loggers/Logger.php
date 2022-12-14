<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Spec\Implentation\Loggers;

use Cag\Loggers\LoggerInterface;

class Logger implements LoggerInterface
{
    public function add(
        string $message,
        string $level = 'info',
        ?int $code = null
    ) {
        echo $level.': '.$message.': '.$code;
    }
}
