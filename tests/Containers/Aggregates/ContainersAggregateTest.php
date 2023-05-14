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
use PHPUnit\Framework\TestCase;

class ContainersAggregateTest extends TestCase
{
    private ContainersAggregate $containersAggregate;

    public function setUp(): void
    {
        parent::setUp();
        $this->containersAggregate = new ContainersAggregate();
    }

    public function testGetExeption(): void
    {
        $this->expectExceptionMessage(
            sprintf(
                ContainersAggregate::LOG_NOT_FOUND,
                '', 'test'
            )
        );
        $this->expectExceptionCode(100);
        $this->containersAggregate->get('test');
    }

    public function testAddExeption(): void
    {
        $this->containersAggregate->aggregates['test'] = 'test';
        $this->expectExceptionMessage(
            sprintf(
                ContainersAggregate::LOG_ALREADY_EXIST,
                '','test'
            )
        );
        $this->expectExceptionCode(100);
        $this->containersAggregate->add('test');
    }

    public function testGetIndex(): void
    {
        $this->assertEquals(
            'test',
            $this->containersAggregate->getIndex('test')
        );
    }

    public function testMerge(): void
    {
        $containersAggregate = new ContainersAggregate();
        $containersAggregate->add('test');
        $this->assertInstanceOf(
            ContainersAggregate::class,
            $this->containersAggregate->merge($containersAggregate)
        );
    }
}