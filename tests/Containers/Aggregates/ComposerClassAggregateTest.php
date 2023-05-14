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

use Cag\Containers\Aggregates\ComposerClassAggregate;
use Cag\Containers\Models\ComposerClass;
use PHPUnit\Framework\TestCase;

class ComposerClassAggregateTest extends TestCase
{
    private ComposerClassAggregate $composerClassAggregate;
    public function setUp(): void
    {
        parent::setUp();
        $this->composerClassAggregate = new ComposerClassAggregate();
    }

    public function testGetNotFound(): void
    {
        $this->expectExceptionMessage(
            sprintf(
                ComposerClassAggregate::LOG_NOT_FOUND,
                'test'
            )
        );
        $this->expectExceptionCode(ComposerClassAggregate::CODE_NOT_FOUND);
        $this->composerClassAggregate->get('test');
    }

    public function testGet(): void
    {
        $composerClass = new ComposerClass('test');
        $this->composerClassAggregate->aggregates['test'] = $composerClass;
        $this->assertInstanceOf(
            ComposerClass::class,
            $this->composerClassAggregate->get('test')
        );
    }

    public function testAddExeption(): void
    {
        $composerClass = new ComposerClass('test');
        $this->composerClassAggregate->aggregates['test'] = $composerClass;
        $this->expectExceptionMessage(
            sprintf(
                ComposerClassAggregate::LOG_ALREADY_EXIST,
                'test'
            )
        );
        $this->expectExceptionCode(ComposerClassAggregate::CODE_ALREADY_EXIST);
        $this->composerClassAggregate->add($composerClass);
    }

    public function testMerge(): void
    {
        $composerClassAggregate = new ComposerClassAggregate();
        $composerClassAggregate->add(new ComposerClass('test'));
        $this->assertInstanceOf(
            ComposerClassAggregate::class,
            $this->composerClassAggregate->merge($composerClassAggregate)
        );
    }
}