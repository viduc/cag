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
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Models\ComposerClass;
use PHPUnit\Framework\TestCase;

class ComposerClassAggregateTest extends TestCase
{
    private ComposerClassAggregate $composerClassAggregate;
    #[\Override]
    public function setUp(): void
    {
        $this->composerClassAggregate = new ComposerClassAggregate();
    }

    /**
     * @throws NotFoundException
     */
    public function testGetNotFound(): void
    {
        $this->expectExceptionMessage(
            message: sprintf(
                ComposerClassAggregate::LOG_NOT_FOUND,
                'test'
            )
        );
        $this->expectExceptionCode(code: ComposerClassAggregate::CODE_NOT_FOUND);
        $this->composerClassAggregate->get(class: 'test');
    }

    /**
     * @throws NotFoundException
     */
    public function testGet(): void
    {
        $composerClass = new ComposerClass(class: 'test');
        $this->composerClassAggregate->aggregates['test'] = $composerClass;
        $this->assertInstanceOf(
            expected: ComposerClass::class,
            actual: $this->composerClassAggregate->get(class: 'test')
        );
    }

    /**
     * @throws ComposerException
     */
    public function testAddExeption(): void
    {
        $composerClass = new ComposerClass(class: 'test');
        $this->composerClassAggregate->aggregates['test'] = $composerClass;
        $this->expectExceptionMessage(
            message: sprintf(
                ComposerClassAggregate::LOG_ALREADY_EXIST,
                'test'
            )
        );
        $this->expectExceptionCode(code: ComposerClassAggregate::CODE_ALREADY_EXIST);
        $this->composerClassAggregate->add(class: $composerClass);
    }

    public function testMerge(): void
    {
        $composerClassAggregate = new ComposerClassAggregate();
        $composerClassAggregate->add(class: new ComposerClass(class: 'test'));
        $this->assertInstanceOf(
            expected: ComposerClassAggregate::class,
            actual: $this->composerClassAggregate->merge($composerClassAggregate)
        );
    }
}