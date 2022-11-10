<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Presenters;

use Cag\Responses\ResponseInterface;

interface PresenterInterface
{
    /**
     * @param ResponseInterface $reponse
     *
     * @return void
     */
    public function presente(ResponseInterface $reponse): void;

    /**
     * @codeCoverageIgnore
     * @return ResponseInterface
     */
    public function getReponse(): ResponseInterface;
}
