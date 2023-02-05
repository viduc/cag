<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Responses;

use Cag\Containers\ContainerAbstract;
use Cag\Models\ErrorModel;

abstract class ResponseAbstract extends ContainerAbstract implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    abstract public function setErreur(ErrorModel $erreur): void;

    /**
     * @inheritDoc
     */
    abstract public function getErreur(): ErrorModel;
}
