<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Validators;

use Cag\Containers\Exceptions\ComposerException;
use ReflectionClass;
use ReflectionException;
use Cag\Containers\ClassSearchAbstract;

abstract class ExternalWireValidatorAbstract implements ValidatorInterface
{
    const DEPENDENCY_NAMESPACE = 'dependencies';

    /**
     * @param String $class
     *
     * @return bool
     */
    public static function validNameSpace(String $class): bool
    {
        return str_contains(
            haystack: strtolower(string: $class),
            needle: self::DEPENDENCY_NAMESPACE
        );
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public static function validInterface(string $class): bool
    {
        try {
            $reflexion = new ReflectionClass(objectOrClass: $class);
            return $reflexion->isInterface() &&
                count(
                    value: ClassSearchAbstract::getInterfaceImplementations(
                        interface: $class
                    )
                ) === 0;
        } catch (ReflectionException|ComposerException) {
            return false;
        }
    }
}
