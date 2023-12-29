<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Providers;

use Cag\Containers\Aggregates\AggregateInterface;
use Cag\Containers\Aggregates\DefinitionsAggregate;
use Cag\Containers\ClassSearchAbstract;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Validators\ExternalWireValidatorAbstract;

class ExternalWireProvider implements ProviderInterface
{
    public DefinitionsAggregate $aggregate;

    public function provides(string $id): bool
    {
        return ExternalWireValidatorAbstract::validNameSpace(class: $id)
            && ExternalWireValidatorAbstract::validInterface(class: $id);
    }

    /**
     * @throws DefinitionException
     * @throws ComposerException
     */
    public function register(): void
    {
        $this->aggregate = new DefinitionsAggregate();
        $list = ClassSearchAbstract::getAllDependencyInterface();
        array_walk(
            array: $list,
            callback: function ($interface) {
                $class = $interface->class;
                if ($this->provides(id: $class)) {
                    $this->aggregate->add(
                        param: new Definition(
                            class: $class,
                            name: $class,
                            external: true
                        )
                    );
                }
            }
        );
    }

    /**
     * @throws DefinitionException
     */
    public function get(string $id): Definition
    {
        return $this->aggregate->get(param: $id);
    }

    public function getAggregate(): AggregateInterface
    {
        return $this->aggregate;
    }
}
