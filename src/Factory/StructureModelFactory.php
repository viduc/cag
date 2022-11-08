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

use Cag\Models\StructureModel;

abstract class StructureModelFactory extends AbstractFactory
{
    const FOLDERS = [
        'Adapters',
        'Containers',
        'Controllers',
        'Exceptions',
        'Factory',
        'Models',
        'Presenters',
        'Responses',
        'Repository',
        'Requests',
        'Services',
        'Validators'
    ];

    static public function getStandard(): StructureModel
    {

    }
}
