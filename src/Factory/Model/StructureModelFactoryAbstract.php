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

abstract class StructureModelFactoryAbstract implements ModelFactoryInterface
{
    abstract public function getStandard(
        string $name,
        string|null $path = 'src'
    ): StructureModel;
}
