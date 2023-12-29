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

interface ProviderInterface
{
    public function provides(string $id): bool;

    public function register(): void;

    public function getAggregate(): AggregateInterface;
}
