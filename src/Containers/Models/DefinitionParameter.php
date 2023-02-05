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

class DefinitionParameter
{
    /**
     * @var string
     */
    public string $definition_id;

    /**
     * @var string
     */
    public string $parameter_id;

    /**
     * @param string $definition_id
     * @param string $parameter_id
     */
    public function __construct(string $definition_id, string $parameter_id)
    {
        $this->definition_id = $definition_id;
        $this->parameter_id = $parameter_id;
    }
}
