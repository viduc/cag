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

use Random\RandomException;

class Parameter
{
    public string $id;

    public string $type;

    public string $name;

    public mixed $value;

    public bool $isDefinition;

    /**
     * @throws RandomException
     */
    public function __construct(
        mixed $value,
        string $name,
        bool $isDefinition = false
    ) {
        $this->value = $value;
        $this->name = $name;
        $this->isDefinition = $isDefinition;
        $this->defineType();
        $this->id = random_int(min: 0, max: 99).'';
    }

    private function defineType(): void
    {
        $this->type = gettype(value: $this->value);
        $this->type = 'string' === $this->type
        && str_starts_with(haystack: $this->value, needle: '%')
        && str_ends_with(haystack: $this->value, needle: '%') ? 'class' : $this->type;
        $this->type = $this->isDefinition ? 'definition' : $this->type;
    }

    public function __equals(self $other): bool
    {
        return $this->value === $other->value
            && $this->type === $other->type
            && $this->name === $other->name;
    }

    public function isClass(): bool
    {
        return 'class' === $this->type;
    }
}
