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

use ReflectionClass;
use ReflectionException;
use Cag\Containers\Exceptions\NotFoundException;

class ImplementationAggregate implements AggregateInterface
{
    const LOG_NOT_FOUND = 'Class %s not found';
    const LOG_NOT_FOUND_CODE = 100;

    /**
     * @var array
     */
    public array $implementations = [];

    /**
     * @param string $param
     *
     * @return bool
     */
    public function has(string $param): bool
    {
        return isset($this->implementations[$param]);
    }

    /**
     * @param string $param
     *
     * @return mixed
     * @throws NotFoundException
     */
    public function get(string $param): mixed
    {
        if ($this->has($param)) {
            return $this->implementations[$param];
        }

        throw new NotFoundException(
            sprintf(
                self::LOG_NOT_FOUND,
                $param
            ),
            self::LOG_NOT_FOUND_CODE
        );
    }

    /**
     * @param mixed $param
     *
     * @return void
     * @throws ReflectionException
     */
    public function add(mixed $param): void
    {
        $reflection = new ReflectionClass($param);
        $this->implementations[$reflection->getName()] = $param;
    }

    /**
     * @param AggregateInterface $aggregate
     *
     * @return AggregateInterface
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        return $this;
    }
}