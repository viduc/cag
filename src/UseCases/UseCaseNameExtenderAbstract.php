<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\UseCases;

abstract class UseCaseNameExtenderAbstract
{
    public static function extend(string $useCase): string
    {
        return self::completeNameSpace(name: self::completeClassName(name: $useCase));
    }

    private static function completeClassName(string $name): string
    {
        return str_ends_with(haystack: $name, needle: 'UseCase') ? $name : $name.'UseCase';
    }

    private static function completeNameSpace(string $name): string
    {
        $reflexion = new \ReflectionClass(objectOrClass: self::class);

        return str_starts_with(
            haystack: $name,
            needle: $reflexion->getNamespaceName()
        ) ? $name : $reflexion->getNamespaceName().'\\'.$name;
    }
}
