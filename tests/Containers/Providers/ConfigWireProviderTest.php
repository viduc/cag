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
use Cag\Containers\Models\Definition;
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
     * @var ConfigWireProvider|null
     */
    private ConfigWireProvider|null $provider;

    /**
     * @return void
     * @throws DefinitionException
     * @throws NotFoundException
     */
    #[\Override]
    protected function setUp(): void
    {
        ComposerAbstract::autoload();
        $path = str_replace(
            search: 'Providers',
            replace: 'Config',
            subject: __DIR__
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
            condition: $this->provider->getAggregate()->has(
                param: WithStringParam::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            definition: $this->provider->getAggregate()->get(
                param: WithStringParam::class
            )
        ) as $parameter) {
            self::assertTrue(
                in_array(
                    needle: $this->provider->parameterAggregate->getById(
                        id: $parameter->parameter_id
                    )->name,
                    haystack: ['test', 'toto']
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
            condition: $this->provider->aggregate->has(
                param: WithInterfaceParamMultiImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            definition: $this->provider->getAggregate()->get(
                param: WithInterfaceParamMultiImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                condition: in_array(
                    needle: $this->provider->parameterAggregate->getById(
                        id: $parameter->parameter_id
                    )->value,
                    haystack: ['%'.ImpWithMultipleImp1::class.'%']
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
            condition: $this->provider->aggregate->has(
                param: WithAbstractParamMultiImp::class
            )
        );
        foreach ($this->provider->definitionParameterAggregate->getByDefinition(
            definition: $this->provider->getAggregate()->get(
                param: WithAbstractParamMultiImp::class
            )
        ) as $parameter) {
            self::assertTrue(
                condition: in_array(
                    needle: $this->provider->parameterAggregate->getById(
                        id: $parameter->parameter_id
                    )->value,
                    haystack: ['%'.ImpWithMultipleAbstract1::class.'%']
                )
            );
        }
    }

    /**
     * @throws DefinitionException
     * @throws NotFoundException
     */
    public function testShouldReturnDefinition(): void
    {
        self::assertInstanceOf(
            expected: Definition::class,
            actual: $this->provider->getDefinition(
                name: WithAbstractParamMultiImp::class
            )
        );
    }

    /**
     * @throws NotFoundException
     */
    public function testShouldNotRegister(): void
    {
        $this->provider->list = ['test' => ['class' => 'toto']];
        $this->expectException(exception: DefinitionException::class);
        $this->provider->register();
    }

    public function testShouldProvides(): void
    {
        self::assertTrue(
            condition: $this->provider->provides(id: WithStringParam::class)
        );
    }

    public function testConstructWithPathNull(): void
    {
        $this->provider = new ConfigWireProvider(path: null);
        self::assertIsArray(actual: $this->provider->list);
    }
}
