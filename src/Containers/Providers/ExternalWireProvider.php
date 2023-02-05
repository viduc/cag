<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
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
    /**
     * @var DefinitionsAggregate
     */
    public DefinitionsAggregate $aggregate;

    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool
    {
        return ExternalWireValidatorAbstract::validNameSpace($id) &&
            ExternalWireValidatorAbstract::validInterface($id);
    }

    /**
     * @return void
     * @throws DefinitionException
     * @throws ComposerException
     */
    public function register(): void
    {
        $this->aggregate = new DefinitionsAggregate();
        $list = ClassSearchAbstract::getAllDependencyInterface();
        foreach ($list as $interface) {
            $class = $interface->class;
            if ($this->provides($class)) {
                $this->aggregate->add(
                    new Definition($class, $class, true)
                );
            }
        }
    }

    /**
     * @param string $id
     *
     * @return Definition
     * @throws DefinitionException
     */
    public function get(string $id): Definition
    {
        return $this->aggregate->get($id);
    }

    /**
     * @inheritDoc
     */
    public function getAggregate(): AggregateInterface
    {
        return $this->aggregate;
    }
}
