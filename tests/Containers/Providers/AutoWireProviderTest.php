<?php
declare(strict_types=1);
/**
 * This file is part of the Cag package.
 *
 * (c) GammaSoftware <http://www.winlassie.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cag\Tests\Containers\Providers;

use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Providers\AutoWireProvider;
use Cag\Spec\Mock\ClassForProvider\AbstractClass;
use Cag\Spec\Mock\ClassForProvider\Implementations\ImpWithOneAbstract;
use Cag\Spec\Mock\ClassForProvider\Implementations\ImpWithOneImp;
use Cag\Spec\Mock\ClassForProvider\Interfaces\WithOneImpInterface;
use Cag\Spec\Mock\ClassForProvider\Simple;
use Cag\Spec\Mock\ClassForProvider\TraitClass;
use Cag\Spec\Mock\ClassForProvider\WithAbstractParamOneImp;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamMultiImp;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamOneImp;
use Cag\Spec\Mock\ClassForProvider\WithSimpleClassParam;
use Cag\Tests\Containers\Config\ComposerAbstract;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class AutoWireProviderTest extends TestCase
{
    /**
     * @var AutoWireProvider
     */
    public AutoWireProvider $provider;

    /**
     * @throws ReflectionException
     * @throws DefinitionException
     */
    public function setUp(): void
    {
        parent::setUp();
        ComposerAbstract::autoload();
        $this->provider = new AutoWireProvider();
        $this->provider->register();
    }

    /**
     * @return void
     */
    public function testShouldRegisterClassWithNoParam(): void
    {
        /* should have a class with no param*/
        self::assertTrue(
            $this->provider->getAggregate()->has(Simple::class)
        );
    }

    public function testShouldRegisterClassWithSimpleClassParam(): void
    {
        /* should have a class with no param*/
        self::assertTrue(
            $this->provider->getAggregate()->has(WithSimpleClassParam::class)
        );
    }

    /**
     * @return void
     */
    public function testRShouldNotRegister(): void
    {
        /* should not have an interface */
        self::assertFalse(
            $this->provider->getAggregate()->has(
                WithOneImpInterface::class
            )
        );

        /* should not have an abstract class */
        self::assertFalse(
            $this->provider->getAggregate()->has(AbstractClass::class)
        );

        /* should not have an trait class */
        self::assertFalse(
            $this->provider->getAggregate()->has(TraitClass::class)
        );
    }

    /**
     * @return void
     * @throws DefinitionException
     */
    public function testShouldRegisterWithParamInterface(): void
    {
        /* should have a class with class param */
        self::assertTrue(
            $this->provider->getAggregate()->has(
                WithInterfaceParamOneImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            $this->provider->getAggregate()->get(
                WithInterfaceParamOneImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    $this->provider->parameterAggregate->getById(
                        $parameter->parameter_id
                    )->value,
                    [ImpWithOneImp::class]
                )
            );
        }
    }

    /**
     * @return void
     * @throws DefinitionException
     */
    public function testShouldRegisterWithParamAbstract(): void
    {
        /* should have a class with class param */
        self::assertTrue(
            $this->provider->getAggregate()->has(
                WithAbstractParamOneImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            $this->provider->getAggregate()->get(
                WithAbstractParamOneImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    $this->provider->parameterAggregate->getById(
                        $parameter->parameter_id
                    )->value,
                    [ImpWithOneAbstract::class]
                )
            );
        }
    }

    /**
     * @return void
     */
    public function testShouldNotRegisterWithParamInterfaceWithMultipleImplementation(): void
    {
        /* should have a class with class param */
        self::assertFalse(
            $this->provider->getAggregate()->has(
                WithInterfaceParamMultiImp::class
            )
        );
    }
}
