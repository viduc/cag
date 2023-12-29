<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Containers\Aggregates;

use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\DefinitionParameter;
use Random\RandomException;

class DefinitionParameterAggregate implements AggregateInterface
{
    public const LOG_NOT_FOUND = '%s with %s name not found';
    public const LOG_ALREADY_EXIST = '%s with %s already exist';
    public const TYPE = 'DefinitionParameter';
    public const CODE_NOT_FOUND = 100;
    public const CODE_ALREADY_EXIST = 101;

    /**
     * @var DefinitionParameter[]
     */
    public array $aggregates = [];

    /**
     * @param DefinitionParameter $definitionParam
     *
     * @throws RandomException
     */
    public function getIndex(mixed $definitionParam): string
    {
        return random_int(min: 0, max: 99).'';
    }

    public function has(string $param, string $parameter = null): bool
    {
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $param
                && $value->parameter_id === $parameter
            ) {
                return true;
            }
        }

        return false;
    }

    public function hasByIndex(string $index): bool
    {
        return isset($this->aggregates[$index]);
    }

    /**
     * @throws DefinitionException
     */
    public function add(mixed $param, string $index = null): void
    {
        $index = is_null(value: $index) ?
            $this->getIndex(definitionParam: $param) : $index;
        if ($this->has(param: $index)) {
            throw new DefinitionException(message: sprintf(self::LOG_ALREADY_EXIST, self::TYPE, $index), code: self::CODE_ALREADY_EXIST);
        }
        $this->aggregates[$index] = $param;
    }

    /**
     * @throws DefinitionException
     */
    public function get(string $class, string $parameter = null): mixed
    {
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $class
                && $value->parameter_id === $parameter
            ) {
                return $value;
            }
        }

        throw new DefinitionException(message: sprintf(self::LOG_NOT_FOUND, self::TYPE, $class.' or '.$parameter), code: self::CODE_NOT_FOUND);
    }

    /**
     * @return DefinitionParameter[]
     */
    public function getByDefinition(Definition $definition): array
    {
        $definitionParameter = [];
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $definition->name) {
                $definitionParameter[] = $value;
            }
        }

        return $definitionParameter;
    }

    /**
     * @throws DefinitionException
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        foreach ($aggregate->aggregates as $index => $aggregate) {
            if (!$this->hasByIndex(index: $index.'')) {
                $this->add(param: $aggregate, index: $index.'');
            }
        }

        return $this;
    }

    public function getAllByDefinition(Definition $definition): array
    {
        $definitionParameter = [];
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $definition->name) {
                $definitionParameter[] = $value;
            }
        }

        return $definitionParameter;
    }
}
