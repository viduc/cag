<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Validators;

use Cag\Containers\ClassSearchAbstract;
use Cag\Containers\Exceptions\ComposerException;

abstract class ExternalWireValidatorAbstract implements ValidatorInterface
{
    public const DEPENDENCY_NAMESPACE = 'dependencies';

    public static function validNameSpace(string $class): bool
    {
        return str_contains(
            haystack: strtolower(string: $class),
            needle: self::DEPENDENCY_NAMESPACE
        );
    }

    public static function validInterface(string $class): bool
    {
        try {
            $reflexion = new \ReflectionClass(objectOrClass: $class);

            return $reflexion->isInterface()
                && 0 === count(
                    value: ClassSearchAbstract::getInterfaceImplementations(
                        interface: $class
                    )
                );
        } catch (\ReflectionException|ComposerException) {
            return false;
        }
    }
}
