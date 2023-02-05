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
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Providers\ConfigWireProvider;
use Cag\Spec\Mock\ClassForProvider\Implementations\ImpWithMultipleAbstract1;
use Cag\Spec\Mock\ClassForProvider\Implementations\ImpWithMultipleImp1;
use Cag\Spec\Mock\ClassForProvider\WithAbstractParamMultiImp;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamMultiImp;
use Cag\Spec\Mock\ClassForProvider\WithStringParam;
use Cag\Tests\Containers\Config\ComposerAbstract;
use PHPUnit\Framework\TestCase;

class ConfigWireProviderTest extends TestCase
{
    /**
     * @var ConfigWireProvider
     */
    private ConfigWireProvider $provider;

    /**
     * @return void
     * @throws DefinitionException
     * @throws NotFoundException
     */
    protected function setUp(): void
    {
        parent::setUp();
        ComposerAbstract::autoload();
        $path = str_replace(
            'Providers',
            'Config',
            __DIR__
        );
        $path .= '/container.yml';
        $this->provider = new ConfigWireProvider($path);
        $this->provider->register();
    }

    /**
     * @return void
     * @throws DefinitionException
     */
    public function testRegisterWithStringParam(): void
    {
        self::assertTrue(
            $this->provider->getAggregate()->has(
                WithStringParam::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            $this->provider->getAggregate()->get(
                WithStringParam::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    $this->provider->parameterAggregate->getById(
                        $parameter->parameter_id
                    )->name,
                    ['test', 'toto']
                )
            );
        }
    }

    /**
     * @return void
     * @throws DefinitionException
     */
    public function testRegisterWithInterfaceMultipleImp(): void
    {
        self::assertTrue(
            $this->provider->aggregate->has(
                WithInterfaceParamMultiImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            $this->provider->getAggregate()->get(
                WithInterfaceParamMultiImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    $this->provider->parameterAggregate->getById(
                        $parameter->parameter_id
                    )->value,
                    ['%'.ImpWithMultipleImp1::class.'%']
                )
            );
        }
    }

    /**
     * @return void
     * @throws DefinitionException
     */
    public function testRegisterWithAbstractMultipleImp(): void
    {
        self::assertTrue(
            $this->provider->aggregate->has(
                WithAbstractParamMultiImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            $this->provider->getAggregate()->get(
                WithAbstractParamMultiImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    $this->provider->parameterAggregate->getById(
                        $parameter->parameter_id
                    )->value,
                    ['%'.ImpWithMultipleAbstract1::class.'%']
                )
            );
        }
    }
}
