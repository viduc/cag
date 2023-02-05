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

interface AggregateInterface
{
    /**
     * @param string $param
     *
     * @return bool
     */
    public function has(string $param): bool;

    /**
     * @param string $param
     *
     * @return mixed
     */
    public function get(string $param): mixed;

    /**
     * @param mixed $param
     *
     * @return void
     */
    public function add(mixed $param): void;

    /**
     * @param AggregateInterface $aggregate
     *
     * @return void
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface;
}
