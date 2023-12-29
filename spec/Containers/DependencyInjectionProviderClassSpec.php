<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
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
    message: 'Specification to Container\Providers\DependencyInjectionProvider',
    closure: function () {
        beforeAll(
            closure: function () {ComposerAbstract::autoload();}
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
                    search: 'spec/Containers',
                    replace: 'tests/Containers/Config',
                    subject: __DIR__
                );
                $path .= '/container.yml';
                $this->provider = new DependencyInjectionProvider(path: $path);
            }
        );

        describe(
            message: 'Specification to provides methode',
            closure: function () {
                with_provided_data_it(
                    message: "should provide a {:0}",
                    closure: function($message, $class) {
                        expect(
                            actual: $this->provider->provides(id: $class)
                        )->toBeTruthy();
                    },
                    provider: function () {
                        yield [
                            'simple class with no param (autowire)',
                            Simple::class
                        ];
                        yield [
                            'class with internal class (simple) param (autowire)',
                            WithSimpleClassParam::class
                        ];
                        yield [
                            'class with valid interface (external) param (autowire)',
                            WithExternalValidInterfaceParam::class
                        ];
                        yield [
                            'class with internal interface param (one imp) (autowire)',
                            WithInterfaceParamOneImp::class
                        ];
                        yield [
                            'class with string param (configwire)',
                            WithStringParam::class
                        ];
                        yield [
                            'class with internal interface param (multiple imp) (configwire)',
                            WithInterfaceParamMultiImp::class
                        ];
                        yield [
                            'class with internal class param who have string param',
                            WithComplexeClassParam::class
                        ];
                    }
                );
                with_provided_data_it(
                    message: "should not provide a {:0}",
                    closure: function($message, $class) {
                        expect($this->provider->provides(id: $class))->toBeFalsy();
                    },
                    provider: function () {
                        yield [
                            'class with interface (external) param (autowire)',
                            WithExternalInterfaceParam::class
                        ];
                        yield [
                            'class with class (external) param (autowire)',
                            WithExternalClassParam::class
                        ];
                    }
                );
            }
        );
    }
);
