<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers;

use ReflectionClass;
use ReflectionException;
use Cag\Containers\Aggregates\ComposerClassAggregate;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Models\ComposerClass;
use Cag\Containers\Validators\ExternalWireValidatorAbstract;

abstract class ClassSearchAbstract
{
    /**
     * @return ComposerClass[]
     */
    public static function getAllClass(): array
    {
        $baseNameSpace = explode('\\', __NAMESPACE__)[0];
        $map = array_keys(
            require(__DIR__ . "/../../vendor/composer/autoload_classmap.php")
        );
        $aggregate = new ComposerClassAggregate();
        array_walk(
            $map,
            function ($class, $key, $aggregate) use ($baseNameSpace) {
                if (str_starts_with($class, $baseNameSpace)) {
                    $aggregate->add(new ComposerClass($class));
                }
            },
            $aggregate
        );

        return $aggregate->aggregates;
    }

    /**
     * @param string $interface
     *
     * @return array
     * @throws ReflectionException
     */
    public static function getInterfaceImplentations(
        string $interface
    ): array {
        $classImplements = [];
        $reflection = new ReflectionClass($interface);
        foreach (ClassSearchAbstract::getAllClass() as $class) {
            if (in_array(
                $reflection->getName(),
                array_merge(
                    class_implements($class->class),
                    class_parents($class->class)
                )
            )) {
                $classImplements[] = $class;
            }
        }
        return $classImplements;
    }

    /**
     * @return array
     * @throws Exceptions\ComposerException
     * @throws ReflectionException
     */
    public static function getAllInterfaceWithoutImplementation(): array
    {
        $aggregate = new ComposerClassAggregate();
        foreach (ClassSearchAbstract::getAllClass() as $class) {
            if (0 === count(
                ClassSearchAbstract::getInterfaceImplentations($class->class)
            )) {
                $aggregate->add($class);
            }
        }

        return $aggregate->aggregates;
    }

    /**
     * @throws ComposerException
     */
    public static function getAllDependencyInterface(): array
    {
        $aggregate = new ComposerClassAggregate();
        foreach (ClassSearchAbstract::getAllClass() as $class) {
            if (ExternalWireValidatorAbstract::validInterface($class->class)) {
                $aggregate->add($class);
            }
        }

        return $aggregate->aggregates;
    }
}
