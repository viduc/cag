<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Implentation\Reponse;

use Cag\Model\ErreurModel;
use Cag\Reponse\ReponseInterface;

class ReponseCreateProject implements ReponseInterface
{
    private ErreurModel $erreur;

    /**
     * @inheritDoc
     */
    public function setErreur(ErreurModel $erreur): void
    {
        $this->erreur = $erreur;
    }

    /**
     * @inheritDoc
     */
    public function getErreur(): ErreurModel
    {
        $this->erreur = $this->erreur ?? new ErreurModel();

        return $this->erreur;
    }
}