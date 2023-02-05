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

class ComposerClass
{
    /**
     * @var string
     */
    public string $class;

    /**
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * @param ComposerClass $other
     *
     * @return bool
     */
    public function __equals(ComposerClass $other): bool
    {
        return $this->class === $other->class;
    }
}
