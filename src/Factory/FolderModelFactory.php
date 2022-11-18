<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory;

use Cag\Models\FolderModel;

class FolderModelFactory extends FactoryAbstract
{
    /**
     * @param string $name
     *
     * @return FolderModel
     */
    public function getStandard(string $name): FolderModel
    {
        return new FolderModel($name);
    }
}
