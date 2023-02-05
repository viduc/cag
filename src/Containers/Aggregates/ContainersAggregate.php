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

class ContainersAggregate implements AggregateInterface
{
    const LOG_NOT_FOUND = "%s with %s name not found";
    const LOG_ALREADY_EXIST = "%s with %s already exist";

    protected string $type = "";
    protected int $code_not_found = 100;
    protected int $code_already_exist = 100;

    /**
     * @var array
     */
    public array $aggregates;

    /**
     * @param string $param
     *
     * @return bool
     */
    public function has(string $param): bool
    {
        return isset($this->aggregates[$param]);
    }

    /**
     * @param string $param
     *
     * @return mixed
     * @throws DefinitionException
     */
    public function get(string $param): mixed
    {
        if ($this->has($param)) {
            return $this->aggregates[$param];
        }

        throw new DefinitionException(
            sprintf(self::LOG_NOT_FOUND, $this->type, $param),
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
     * @param mixed $param
     *
     * @return string
     */
    public function getIndex(mixed $param): string
    {
        return $param;
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
            $index = $this->getIndex($aggregate);
            if (!$this->has($index)) {
                $this->add($aggregate);
            }
        }

        return $this;
    }
}
