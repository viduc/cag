<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Requete;

use Cag\Exception\AbstractException;

interface RequeteInterface
{
    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @param string $param
     * @return mixed
     * @throws AbstractException
     */
    public function getParam(string $param): mixed;
}