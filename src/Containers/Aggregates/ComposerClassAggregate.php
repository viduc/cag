<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
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
    public const LOG_NOT_FOUND = 'class with %s name not found';
    public const CODE_NOT_FOUND = 101;
    public const LOG_ALREADY_EXIST = 'class with %s already exist';
    public const CODE_ALREADY_EXIST = 100;

    /**
     * @var ComposerClass[]
     */
    public array $aggregates = [];

    /**
     * @throws NotFoundException
     */
    public function get(string $class): ComposerClass
    {
        if ($this->has(param: $class)) {
            return $this->aggregates[$class];
        }

        throw new NotFoundException(message: sprintf(self::LOG_NOT_FOUND, $class), code: self::CODE_NOT_FOUND);
    }

    public function has(string $param): bool
    {
        return isset($this->aggregates[$param]);
    }

    /**
     * @param ComposerClass $class
     *
     * @throws ComposerException
     */
    public function add(mixed $class): void
    {
        if ($this->has(param: $class->class)) {
            throw new ComposerException(message: sprintf(self::LOG_ALREADY_EXIST, $class->class), code: self::CODE_ALREADY_EXIST);
        }
        $this->aggregates[$class->class] = $class;
    }

    /**
     * @throws ComposerException
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        foreach ($aggregate->aggregates as $aggregate) {
            if (!$this->has(param: $aggregate->class)) {
                $this->add(class: $aggregate);
            }
        }

        return $this;
    }
}
