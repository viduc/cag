<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Aggregates;

use Cag\Containers\Models\Definition;

class DefinitionsAggregate extends ContainersAggregate
{
    protected string $type = "Definition";
    protected int $code_not_found = 103;
    protected int $code_already_exist = 104;

    /**
     * @var Definition[]
     */
    public array $aggregates = [];

    /**
     * @param Definition $param
     *
     * @return string
     */
    #[\Override]
    public function getIndex(mixed $param): string
    {
        return $param->name;
    }
}
