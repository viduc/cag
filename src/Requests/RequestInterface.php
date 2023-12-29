<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Requests;

use Cag\Exceptions\ExceptionAbstract;

interface RequestInterface
{
    public function getUseCase(): string;

    public function getAction(): string;

    /**
     * @throws ExceptionAbstract
     */
    public function getParam(string $param): mixed;
}
