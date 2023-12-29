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

interface AggregateInterface
{
    public function has(string $param): bool;

    public function get(string $param): mixed;

    public function add(mixed $param): void;

    /**
     * @return void
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface;
}
