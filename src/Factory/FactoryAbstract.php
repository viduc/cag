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

use Cag\Loggers\LoggerInterface;
use Cag\Constantes\LogConstantes;

abstract class FactoryAbstract
{
    /**
     * @var LoggerInterface|null
     */
    protected ?LoggerInterface $logger = null;

    public function __construct(?LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

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
    ) {
        $this->logger?->add($message, $level, $code);
    }
}
