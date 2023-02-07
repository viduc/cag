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

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Cag\Containers\ClassSearchAbstract;

abstract class AutoWireValidatorAbstract implements ValidatorInterface
{
    const PHP_DATA_TYPES = [
        'string',
        'integer',
        'float',
        'boolean',
        'array',
        'object',
        'null',
        'resource'
    ];

    /**
     * @param ReflectionClass $reflection
     *
     * @return bool
     */
    public static function validInstantiable(ReflectionClass $reflection): bool
    {
        return AutoWireValidatorAbstract::validNameSpace($reflection) &&
            !$reflection->isAbstract() &&
            !$reflection->isTrait() &&
            !$reflection->isInterface() &&
            AutoWireValidatorAbstract::validParams($reflection);
    }

    /**
     * @param ReflectionClass $reflexion
     *
     * @return bool
     */
    public static function validNameSpace(ReflectionClass $reflexion): bool
    {
        $baseNameSpace = explode('\\', __NAMESPACE__)[0];
        return explode('\\', $reflexion->getNamespaceName())[0] ===
            $baseNameSpace;
    }

    /**
     * @param ReflectionClass $reflection
     *
     * @return bool
     */
    public static function validParams(ReflectionClass $reflection): bool //TODO refacto this
    {
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return true;
        }
        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getType()->getName();
            try {
                $refectionParam = new ReflectionClass($name);
                if (!AutoWireValidatorAbstract::validParamOptional($parameter) ||
                    (($refectionParam->isInterface() || $refectionParam->isAbstract()) &&
                        !AutoWireValidatorAbstract::validParamInterface(
                            $refectionParam
                        )) ||
                    ($refectionParam->isInstantiable() &&
                        !AutoWireValidatorAbstract::validNameSpace(
                            $refectionParam
                        ))
                ) {
                    return false;
                }
            } catch (ReflectionException) {
                if (in_array($name, self::PHP_DATA_TYPES, true)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return bool
     */
    public static function isParamTypeOfClass(
        ReflectionParameter $parameter
    ): bool {
        $name = $parameter->getType()->getName();
        try {
            $refectionParam = new ReflectionClass($name);
            return true;
        } catch (ReflectionException) {
                return false;
        }
    }

    /**
     * @param ReflectionClass $reflection
     *
     * @return bool
     * @throws ReflectionException
     */
    public static function validParamInterface(ReflectionClass $reflection): bool
    {
        return (AutoWireValidatorAbstract::validNameSpace($reflection) ||
            ExternalWireValidatorAbstract::validNameSpace($reflection->name)) &&
        count(
            ClassSearchAbstract::getInterfaceImplentations($reflection->name)
        ) <= 1;
    }

    /**
     * @param ReflectionParameter $parameter
     *
     * @return bool
     */
    public static function validParamOptional(
        ReflectionParameter $parameter
    ): bool {
        if ($parameter->isOptional()) {
            return true;
        }
        return !in_array(
            $parameter->getType()->getName(),
            AutoWireValidatorAbstract::PHP_DATA_TYPES
        );
    }
}
