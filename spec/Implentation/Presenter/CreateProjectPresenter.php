<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Spec\Implentation\Presenter;

use Cag\Presenter\PresenterInterface;
use Cag\Reponse\ReponseInterface;

class CreateProjectPresenter implements PresenterInterface
{
    private ReponseInterface $reponse;

    /**
     * @inheritDoc
     */
    public function presente(ReponseInterface $reponse): void
    {
        $this->reponse = $reponse;
    }

    /**
     * @inheritDoc
     */
    public function getReponse(): ReponseInterface
    {
        return $this->reponse;
    }
}