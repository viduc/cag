<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\UseCases;

use ReflectionClass;

abstract class UseCaseNameExtenderAbstract
{
    public static function extend(string $useCase): String
    {
        return self::completeNameSpace(self::completeClassName($useCase));
    }

    private static function completeClassName(string $name): string
    {
        return str_ends_with($name, 'UseCase') ? $name : $name.'UseCase';
    }

    private static function completeNameSpace(string $name): string
    {
        $reflexion = new ReflectionClass(self::class);
        return str_starts_with($name, $reflexion->getNamespaceName()) ? $name :
            $reflexion->getNamespaceName().'\\'.$name;
    }
}