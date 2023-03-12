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

use Cag\Models\ErrorModel;

class ErreurModelFactoryAbstract
{
    /**
     * @return ErrorModel
     */
    public static function get(): ErrorModel
    {
        return new ErrorModel();
    }
}
