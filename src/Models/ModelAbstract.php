<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

abstract class ModelAbstract
{
    /**
     * @var mixed|null
     */
    protected mixed $id = null;

    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return $this
     */
    public function setId(mixed $id)
    {
        $this->id = $id;

        return $this;
    }
}
