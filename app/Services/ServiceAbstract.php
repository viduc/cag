<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Services;

use App\Containers\DependencyInjection;

class ServiceAbstract
{
    public DependencyInjection $container;

    public function __construct(DependencyInjection $container)
    {
        $this->container = $container;
    }
}
