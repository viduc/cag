<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Reponse;

use Cag\Model\ErreurModel;

interface ReponseInterface
{
    /**
     * @param ErreurModel $erreur
     * @return void
     */
    public function setErreur(ErreurModel $erreur): void;

    /**
     * @return ErreurModel
     */
    public function getErreur(): ErreurModel;
}