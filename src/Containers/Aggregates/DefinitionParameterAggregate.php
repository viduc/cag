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

use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Models\Definition;
use Cag\Containers\Models\DefinitionParameter;

class DefinitionParameterAggregate implements AggregateInterface
{
    const LOG_NOT_FOUND = "%s with %s name not found";
    const LOG_ALREADY_EXIST = "%s with %s already exist";
    const TYPE = "DefinitionParameter";
    const CODE_NOT_FOUND = 100;
    const CODE_ALREADY_EXIST = 101;

    /**
     * @var DefinitionParameter[]
     */
    public array $aggregates = [];

    /**
     * @param DefinitionParameter $definitionParam
     *
     * @return string
     */
    public function getIndex(mixed $definitionParam): string
    {
        return mt_rand().'';
    }

    /**
     * @param string      $param
     * @param string|null $parameter
     *
     * @return bool
     */
    public function has(string $param, string $parameter = null): bool
    {
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $param &&
                $value->parameter_id === $parameter
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $index
     *
     * @return bool
     */
    public function hasByIndex(string $index): bool
    {
        return isset($this->aggregates[$index]);
    }

    /**
     * @param mixed       $param
     * @param string|null $index
     *
     * @return void
     * @throws DefinitionException
     */
    public function add(mixed $param, string $index = null): void
    {
        $index = is_null(value: $index) ?
            $this->getIndex(definitionParam: $param): $index;
        if ($this->has(param: $index)) {
            throw new DefinitionException(
                message: sprintf(
                    self::LOG_ALREADY_EXIST,
                    self::TYPE,
                    $index
                ),
                code: self::CODE_ALREADY_EXIST
            );
        }
        $this->aggregates[$index] = $param;
    }

    /**
     * @param string      $class
     * @param string|null $parameter
     *
     * @return mixed
     * @throws DefinitionException
     */
    public function get(string $class, string $parameter = null): mixed
    {
        foreach ($this->aggregates as $value) {
            if ($value->definition_id === $class &&
                $value->parameter_id === $parameter
            ) {
                return $value;
            }
        }

        throw new DefinitionException(
            message: sprintf(
                self::LOG_NOT_FOUND,
                self::TYPE,
                $class.' or '.$parameter
            ),
            code: self::CODE_NOT_FOUND
        );
    }

    /**
     * @param Definition $definition
     *
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
     * @param AggregateInterface $aggregate
     *
     * @return AggregateInterface
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

    /**
     * @param Definition $definition
     *
     * @return array
     */
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
