<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */


namespace Cag\Tests\Containers\Aggregates;

use Cag\Containers\Aggregates\ContainersAggregate;
use Cag\Containers\Exceptions\DefinitionException;
use PHPUnit\Framework\TestCase;

class ContainersAggregateTest extends TestCase
{
    private ContainersAggregate $containersAggregate;

    #[\Override]
    public function setUp(): void
    {
        $this->containersAggregate = new ContainersAggregate();
    }

    /**
     * @throws DefinitionException
     */
    public function testGetExeption(): void
    {
        $this->expectExceptionMessage(
            message: sprintf(
                ContainersAggregate::LOG_NOT_FOUND,
                '', 'test'
            )
        );
        $this->expectExceptionCode(code: 100);
        $this->containersAggregate->get(param: 'test');
    }

    /**
     * @throws DefinitionException
     */
    public function testAddExeption(): void
    {
        $this->containersAggregate->aggregates['test'] = 'test';
        $this->expectExceptionMessage(
            message: sprintf(
                ContainersAggregate::LOG_ALREADY_EXIST,
                '','test'
            )
        );
        $this->expectExceptionCode(code: 100);
        $this->containersAggregate->add(param: 'test');
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(
            expected: 'test',
            actual: $this->containersAggregate->getIndex(param: 'test')
        );
    }

    /**
     * @throws DefinitionException
     */
    public function testMerge(): void
    {
        $containersAggregate = new ContainersAggregate();
        $containersAggregate->add(param: 'test');
        $this->assertInstanceOf(
            expected: ContainersAggregate::class,
            actual: $this->containersAggregate->merge(
                aggregate: $containersAggregate
            )
        );
    }
}