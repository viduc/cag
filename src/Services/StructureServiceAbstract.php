<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Services;

use Cag\Models\StructureModel;

abstract class StructureServiceAbstract implements ServiceInterface
{
    abstract public function create(StructureModel $model): void;
}
