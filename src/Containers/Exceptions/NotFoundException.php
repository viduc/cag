<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Exceptions;

/**
 * 100 -> 'Service '.$param.' not found in caontainer yaml config'
 * 101 -> class with %s name not found".
 */
class NotFoundException extends ExceptionAbstract
{
}
