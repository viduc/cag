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
use Cag\Containers\Models\Parameter;

class ParameterAggregate implements AggregateInterface
{
    const LOG_NOT_FOUND = "%s with %s name not found";
    const LOG_ALREADY_EXIST = "%s with %s already exist";
    protected int $code_not_found = 100;
    protected int $code_already_exist = 100;
    protected string $type = "Parameter";

    /**
     * @var Parameter[]
     */
    public array $aggregates = [];

    /**
     * @param string     $name
     * @param mixed|null $value
     *
     * @return bool
     */
    public function has(string $name, mixed $value = null): bool
    {
        foreach ($this->aggregates as $param) {
            if ($param->name === $name && $param->value === $value) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function hasById(string $id): bool
    {
        return isset($this->aggregates[$id]);
    }

    /**
     * @param string     $name
     * @param mixed|null $value
     *
     * @return mixed
     * @throws DefinitionException
     */
    public function get(string $name, mixed $value = null): mixed
    {
        foreach ($this->aggregates as $param) {
            if ($param->name === $name && $param->value === $value) {
                return $param;
            }
        }

        throw new DefinitionException(
            sprintf(
                self::LOG_NOT_FOUND,
                $this->type,
                $name
            ),
            $this->code_not_found
        );
    }

    /**
     * @param string $id
     *
     * @return Parameter
     * @throws DefinitionException
     */
    public function getById(string $id): Parameter
    {
        if ($this->hasById($id)) {
            return $this->aggregates[$id];
        }

        throw new DefinitionException(
            sprintf(
                self::LOG_NOT_FOUND,
                $this->type,
                $id
            ),
            $this->code_not_found
        );
    }

    /**
     * @param mixed $param
     *
     * @return void
     * @throws DefinitionException
     */
    public function add(mixed $param): void
    {
        $index = $this->getIndex($param);
        if ($this->has($index)) {
            throw new DefinitionException(
                sprintf(self::LOG_ALREADY_EXIST, $this->type, $index),
                $this->code_already_exist
            );
        }
        $this->aggregates[$index] = $param;
    }

    /**
     * @param Parameter $parameter
     *
     * @return string
     */
    public function getIndex(mixed $parameter): string
    {
        return $parameter->id;
    }

    /**
     * @param AggregateInterface $aggregate
     *
     * @return AggregateInterface
     * @throws DefinitionException
     */
    public function merge(AggregateInterface $aggregate): AggregateInterface
    {
        foreach ($aggregate->aggregates as $aggregate) {
            if (!$this->has($this->getIndex($aggregate))) {
                $this->add($aggregate);
            }
        }

        return $this;
    }
}
