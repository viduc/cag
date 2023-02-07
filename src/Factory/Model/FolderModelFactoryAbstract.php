<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory\Model;

use Cag\Models\FolderModel;

abstract class FolderModelFactoryAbstract implements ModelFactoryInterface
{
    /**
     * @param string $name
     * @return FolderModel
     */
    public abstract  function getStandard(string $name): FolderModel;
}