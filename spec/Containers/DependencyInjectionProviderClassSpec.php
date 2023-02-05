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

use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Containers\Providers\DependencyInjectionProvider;
use Cag\Spec\Mock\ClassForProvider\Simple;
use Cag\Spec\Mock\ClassForProvider\WithComplexeClassParam;
use Cag\Spec\Mock\ClassForProvider\WithExternalClassParam;
use Cag\Spec\Mock\ClassForProvider\WithExternalInterfaceParam;
use Cag\Spec\Mock\ClassForProvider\WithExternalValidInterfaceParam;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamMultiImp;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamOneImp;
use Cag\Spec\Mock\ClassForProvider\WithSimpleClassParam;
use Cag\Spec\Mock\ClassForProvider\WithStringParam;
use Cag\Tests\Containers\Config\ComposerAbstract;

describe(
    'Specification to Container\Providers\DependencyInjectionProvider',
    function () {
        beforeAll(
            function () {
                ComposerAbstract::autoload();
            }
        );
        beforeEach(
            /**
             * @throws ReflectionException
             * @throws DefinitionException
             * @throws ComposerException
             * @throws NotFoundException
             */
            function () {
                $path = str_replace(
                    'spec/Containers',
                    'tests/Containers/Config',
                    __DIR__
                );
                $path .= '/container.yml';
                $this->provider = new DependencyInjectionProvider($path);
            }
        );

        describe(
            'Specification to provides methode',
            function () {
                it(
                    'should provide a simple class with no param (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(Simple::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should provide a class with internal class (simple) param (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(WithSimpleClassParam::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should provide a class with valid interface (external) param (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(WithExternalValidInterfaceParam::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should not provide a class with interface (external) param (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(WithExternalInterfaceParam::class)
                        )->toBeFalsy();
                    }
                );
                it(
                    'should not provide a class with class (external) param (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(WithExternalClassParam::class)
                        )->toBeFalsy();
                    }
                );
                it(
                    'should provide a class with internal interface param (one imp) (autowire)',
                    function () {
                        expect(
                            $this->provider->provides(WithInterfaceParamOneImp::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should provide a class with string param (configwire)',
                    function () {
                        expect(
                            $this->provider->provides(WithStringParam::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should provide a class with internal interface param (multiple imp) (configwire)',
                    function () {
                        expect(
                            $this->provider->provides(WithInterfaceParamMultiImp::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should provide a class with internal class param who have string param',
                    function () {
                        expect(
                            $this->provider->provides(WithComplexeClassParam::class)
                        )->toBeTruthy();
                    }
                );
            }
        );
    }
);
