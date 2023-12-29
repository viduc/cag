<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory\Model;

use Cag\Models\StructureModel;

class StructureModelFactory extends StructureModelFactoryAbstract
{
    #[\Override]
    public function getStandard(
        string $name,
        string|null $path = 'src'
    ): StructureModel {
        return new StructureModel(srcName: $name, path: $path);
    }
}
