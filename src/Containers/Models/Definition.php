<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Models;

class Definition
{
    /**
     * name of class.
     */
    public string $class;

    public string $name;

    public bool $external;

    public function __construct(
        string $class,
        string $name = null,
        bool|null $external = false
    ) {
        $this->class = $class;
        $this->name = !is_null(value: $name) ? $name : $class;
        $this->external = $external;
    }

    public function __equals(self $other): bool
    {
        return $this->class === $other->class
            && $this->name === $other->name
            && $this->external === $other->external;
    }
}
