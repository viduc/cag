<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Controller;

use Cag\Presenter\PresenterInterface;
use Cag\Requete\RequeteInterface;

interface UseCaseInterface
{
    public function execute(
        RequeteInterface $requete,
        PresenterInterface $presenter
    ): PresenterInterface;
}