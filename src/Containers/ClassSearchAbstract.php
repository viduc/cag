<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

use Cag\Containers\Aggregates\ComposerClassAggregate;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Models\ComposerClass;
use Cag\Containers\Validators\ExternalWireValidatorAbstract;

abstract class ClassSearchAbstract
{
    /**
     * @return ComposerClass[]
     *
     * @throws ComposerException
     */
    public static function getAllClass(): array
    {
        $baseNameSpace = explode(separator: '\\', string: __NAMESPACE__)[0];
        $map = array_keys(
            array: require (
                str_replace(
                    search: ['/vendor/viduc/cag', '/src/Containers'],
                    replace: '',
                    subject: __DIR__
                ).'/vendor/composer/autoload_classmap.php')
        );
        $aggregate = new ComposerClassAggregate();
        array_walk(
            array: $map,
            callback: function ($class, $key) use ($baseNameSpace, &$aggregate) {
                if (str_starts_with(haystack: $class, needle: $baseNameSpace)) {
                    $aggregate->add(class: new ComposerClass($class));
                }
            }
        );

        return $aggregate->aggregates;
    }

    /**
     * @throws \ReflectionException|ComposerException
     */
    public static function getInterfaceImplementations(
        string $interface
    ): array {
        $classImplements = [];
        $reflection = new \ReflectionClass(objectOrClass: $interface);
        $name = $reflection->getName();
        $allClass = self::getAllClass();
        array_walk(
            array: $allClass,
            callback: static function ($class) use ($name, &$classImplements) {
                if (in_array(
                    needle: $name,
                    haystack: [
                        ...class_implements(object_or_class: $class->class),
                        ...class_parents(object_or_class: $class->class),
                    ]
                )) {
                    $classImplements[] = $class;
                }
            }
        );

        return $classImplements;
    }

    /**
     * @throws ComposerException
     */
    public static function getAllDependencyInterface(): array
    {
        $aggregate = new ComposerClassAggregate();
        foreach (self::getAllClass() as $class) {
            if (ExternalWireValidatorAbstract::validInterface(class: $class->class)) {
                $aggregate->add(class: $class);
            }
        }

        return $aggregate->aggregates;
    }
}
