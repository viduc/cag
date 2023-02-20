<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Aggregates;

use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Models\ComposerClass;

class ComposerClassAggregate implements AggregateInterface
{
    const LOG_NOT_FOUND = "class with %s name not found";
    const CODE_NOT_FOUND = 101;
    const LOG_ALREADY_EXIST = "class with %s already exist";
    const CODE_ALREADY_EXIST = 100;

    /**
     * @var ComposerClass[]
     */
    public array $aggregates = [];

    /**
     * @param string $class
     *
     * @return ComposerClass
     * @throws NotFoundException
     */
    public function get(string $class): ComposerClass
    {
        if ($this->has($class)) {
            return $this->aggregates[$class];
        }

        throw new NotFoundException(
            sprintf(self::LOG_NOT_FOUND, $class),
            self::CODE_NOT_FOUND
        );
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function has(string $class): bool
    {
        return isset($this->aggregates[$class]);
    }

    /**
     * @param ComposerClass $class
     *
     * @return void
     * @throws ComposerException
     */
    public function add(mixed $class): void
    {
        if ($this->has($class->class)) {
            throw new ComposerException(
                sprintf(self::LOG_ALREADY_EXIST, $class->class),
                self::CODE_ALREADY_EXIST
            );
        }
        $this->aggregates[$class->class] = $class;
    }

    /**
     * @param AggregateInterface $aggregate
     *
     * @return AggregateInterface
     * @throws ComposerException
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        foreach ($aggregate->aggregates as $aggregate) {
            if (!$this->has($aggregate->class)) {
                $this->add($aggregate);
            }
        }

        return $this;
    }
}
