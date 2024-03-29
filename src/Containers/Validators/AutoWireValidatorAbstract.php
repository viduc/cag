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

abstract class AutoWireValidatorAbstract implements ValidatorInterface
{
    public const PHP_DATA_TYPES = [
        'string',
        'integer',
        'float',
        'boolean',
        'array',
        'object',
        'null',
        'resource',
    ];

    public static function validInstantiable(\ReflectionClass $reflection): bool
    {
        return self::validNameSpace(reflexion: $reflection)
            && !$reflection->isAbstract()
            && !$reflection->isTrait()
            && !$reflection->isInterface()
            && self::validParams(reflection: $reflection);
    }

    public static function validNameSpace(\ReflectionClass $reflexion): bool
    {
        $baseNameSpace = explode(separator: '\\', string: __NAMESPACE__)[0];

        return explode(
            separator: '\\',
            string: $reflexion->getNamespaceName()
        )[0] === $baseNameSpace;
    }

    public static function validParams(\ReflectionClass $reflection): bool
    {
        $constructor = $reflection->getConstructor();
        if (is_null(value: $constructor)) {
            return true;
        }
        foreach ($constructor->getParameters() as $parameter) {
            if (!self::validParamOptional(parameter: $parameter)
                && !self::isParamInstantiable(parameter: $parameter)) {
                return false;
            }
        }

        return true;
    }

    public static function isParamInstantiable(
        \ReflectionParameter $parameter
    ): bool {
        $name = $parameter->getType()->getName();
        try {
            $refectionParam = new \ReflectionClass(objectOrClass: $name);

            return
                self::isInterfaceinstantiable(reflection: $refectionParam)
                || self::isClassInstantiable(reflection: $refectionParam)
            ;
        } catch (\ReflectionException) {
            return !in_array(
                needle: $name,
                haystack: self::PHP_DATA_TYPES,
                strict: true
            );
        }
    }

    public static function isClassInstantiable(\ReflectionClass $reflection): bool
    {
        if ($reflection->isInstantiable()) {
            return self::validNameSpace(reflexion: $reflection);
        }

        return false;
    }

    /**
     * @throws \ReflectionException
     * @throws ComposerException
     */
    public static function isInterfaceinstantiable(\ReflectionClass $reflection): bool
    {
        if ($reflection->isInterface() || $reflection->isAbstract()) {
            return self::validParamInterface(reflection: $reflection);
        }

        return false;
    }

    /**
     * @throws \ReflectionException|ComposerException
     */
    public static function validParamInterface(\ReflectionClass $reflection): bool
    {
        return (self::validNameSpace(reflexion: $reflection)
            || ExternalWireValidatorAbstract::validNameSpace(class: $reflection->name)
        ) && count(
            value: ClassSearchAbstract::getInterfaceImplementations(
                interface: $reflection->name
            )
        ) <= 1;
    }

    public static function validParamOptional(
        \ReflectionParameter $parameter
    ): bool {
        return $parameter->isOptional();
    }
}
