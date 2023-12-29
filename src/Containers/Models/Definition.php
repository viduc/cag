<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
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
     *
     * @var string
     */
    public string $class;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var bool
     */
    public bool $external;

    /**
     * @param string      $class
     * @param string|null $name
     * @param bool|null   $external
     */
    public function __construct(
        string      $class,
        string|null $name = null,
        bool|null $external = false
    ) {
        $this->class = $class;
        $this->name = !is_null(value: $name) ? $name : $class;
        $this->external = $external;
    }

    /**
     * @param Definition $other
     *
     * @return bool
     */
    public function __equals(self $other): bool
    {
        return $this->class === $other->class &&
            $this->name === $other->name &&
            $this->external === $other->external;
    }
}
