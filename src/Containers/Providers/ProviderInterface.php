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

interface ProviderInterface
{
    /**
     * @param string $id
     *
     * @return bool
     */
    public function provides(string $id): bool;

    /**
     * @return void
     */
    public function register(): void;

    /**
     * @return AggregateInterface
     */
    public function getAggregate(): AggregateInterface;
}
