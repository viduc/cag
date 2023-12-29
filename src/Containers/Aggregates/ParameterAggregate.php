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
use Cag\Containers\Models\Parameter;

class ParameterAggregate implements AggregateInterface
{
    public const LOG_NOT_FOUND = '%s with %s name not found';
    public const LOG_ALREADY_EXIST = '%s with %s already exist';
    private int $code_not_found = 100;
    private int $code_already_exist = 100;
    private string $type = 'Parameter';

    /**
     * @var Parameter[]
     */
    public array $aggregates = [];

    public function has(string $name, mixed $value = null): bool
    {
        foreach ($this->aggregates as $param) {
            if ($param->name === $name && $param->value === $value) {
                return true;
            }
        }

        return false;
    }

    public function hasById(string $id): bool
    {
        return isset($this->aggregates[$id]);
    }

    /**
     * @throws DefinitionException
     */
    public function get(string $name, mixed $value = null): mixed
    {
        foreach ($this->aggregates as $param) {
            if ($param->name === $name && $param->value === $value) {
                return $param;
            }
        }

        throw new DefinitionException(message: sprintf(self::LOG_NOT_FOUND, $this->type, $name), code: $this->code_not_found);
    }

    /**
     * @throws DefinitionException
     */
    public function getById(string $id): Parameter
    {
        if ($this->hasById(id: $id)) {
            return $this->aggregates[$id];
        }

        throw new DefinitionException(message: sprintf(self::LOG_NOT_FOUND, $this->type, $id), code: $this->code_not_found);
    }

    /**
     * @throws DefinitionException
     */
    public function add(mixed $param): void
    {
        $index = $this->getIndex(parameter: $param);
        if ($this->has(name: $index)) {
            throw new DefinitionException(message: sprintf(self::LOG_ALREADY_EXIST, $this->type, $index), code: $this->code_already_exist);
        }
        $this->aggregates[$index] = $param;
    }

    /**
     * @param Parameter $parameter
     */
    public function getIndex(mixed $parameter): string
    {
        return $parameter->id;
    }

    /**
     * @throws DefinitionException
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        foreach ($aggregate->aggregates as $aggregate) {
            if (!$this->has(name: $this->getIndex(parameter: $aggregate))) {
                $this->add(param: $aggregate);
            }
        }

        return $this;
    }
}
