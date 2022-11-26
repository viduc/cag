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

use App\Containers\Container;

class ServiceAbstract
{
    public Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
