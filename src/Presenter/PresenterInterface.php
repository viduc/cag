<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Presenter;

use Cag\Reponse\ReponseInterface;

interface PresenterInterface
{
    /**
     * @param ReponseInterface $reponse
     * @return void
     */
    public function presente(ReponseInterface $reponse): void;

    /**
     * @codeCoverageIgnore
     * @return ReponseInterface
     */
    public function getReponse(): ReponseInterface;
}