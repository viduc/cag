<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Presenters;

use Cag\Responses\ResponseInterface;

interface PresenterInterface
{
    public function presente(ResponseInterface $reponse): void;

    /**
     * @codeCoverageIgnore
     */
    public function getResponse(): ResponseInterface;
}
