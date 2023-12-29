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
 * 100 -> DefinitionParamter with ".$name." name not found
 * 101 -> "DefinitionParamter with ".$param->name." already exist"
 * 102 -> 'Class '.$class->getName().' is not instanciable'
 * 103 -> "Definition with ".$definition." name not found"
 * 104 -> "Definition with ".$definition->name." already exist",.
 */
class DefinitionException extends ExceptionAbstract
{
    public const LOG_NOT_FOUND = 'Definition with %s name not found';
    public const CODE_NOT_FOUND = 103;
}
