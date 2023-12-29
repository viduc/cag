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

class Parameter
{
    /**
     * @var string
     */
    public string $id;

    /**
     * @var string
     */
    public string $type;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var mixed
     */
    public mixed $value;

    /**
     * @var bool
     */
    public bool $isDefinition;

    /**
     * @param mixed  $value
     * @param string $name
     * @param bool   $isDefinition
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
        $this->id = mt_rand().'';
    }

    /**
     * @return void
     */
    private function defineType(): void
    {
        $this->type = gettype(value: $this->value);
        $this->type = $this->type === 'string' &&
        str_starts_with(haystack: $this->value, needle: '%') &&
        str_ends_with(haystack: $this->value, needle: '%') ? 'class': $this->type;
        $this->type = $this->isDefinition ? 'definition': $this->type;
    }

    /**
     * @param Parameter $other
     *
     * @return bool
     */
    public function __equals(self $other): bool
    {
        return $this->value === $other->value
            && $this->type === $other->type
            && $this->name === $other->name;
    }

    /**
     * @return bool
     */
    public function isClass(): bool
    {
        return $this->type === 'class';
    }
}
