<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Model;

class StructureModel extends AbstractModel
{
    /**
     * Nom du projet
     * @var string
     */
    protected $name;

    /**
     * Nom du dossier srcS
     * @var string
     */
    protected $srcName;
}