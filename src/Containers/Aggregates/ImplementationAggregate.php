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

use Cag\Containers\Exceptions\NotFoundException;

class ImplementationAggregate implements AggregateInterface
{
    public const LOG_NOT_FOUND = 'Class %s not found';
    public const LOG_NOT_FOUND_CODE = 100;

    public array $implementations = [];

    public function has(string $param): bool
    {
        return isset($this->implementations[$param]);
    }

    /**
     * @throws NotFoundException
     */
    public function get(string $param): mixed
    {
        if ($this->has(param: $param)) {
            return $this->implementations[$param];
        }

        throw new NotFoundException(message: sprintf(self::LOG_NOT_FOUND, $param), code: self::LOG_NOT_FOUND_CODE);
    }

    /**
     * @throws \ReflectionException
     */
    public function add(mixed $param): void
    {
        $reflection = new \ReflectionClass(objectOrClass: $param);
        $this->implementations[$reflection->getName()] = $param;
    }

    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        return $this;
    }
}
