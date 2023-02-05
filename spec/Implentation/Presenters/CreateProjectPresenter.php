<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Spec\Implentation\Presenters;

use Cag\Presenters\PresenterInterface;
use Cag\Responses\ResponseInterface;

class CreateProjectPresenter implements PresenterInterface
{
    private ResponseInterface $reponse;

    /**
     * @inheritDoc
     */
    public function presente(ResponseInterface $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): ResponseInterface
    {
        return $this->reponse;
    }
}