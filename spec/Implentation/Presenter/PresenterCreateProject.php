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
use Spec\Implentation\Reponse\ReponseCreateProject;

class PresenterCreateProject implements PresenterInterface
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
        $this->reponse = $this->reponse ?? new ReponseCreateProject();

        return $this->reponse;
    }
}