<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Containers\DependencyInjection;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Exceptions\NotFoundException;
use Cag\Spec\Containers\ExternalDependencyInjection;
use Cag\Spec\Mock\ClassForProvider\Simple;
use Cag\Spec\Mock\ClassForProvider\WithComplexeClassParam;
use Cag\Spec\Mock\ClassForProvider\WithExternalClassParam;
use Cag\Spec\Mock\ClassForProvider\WithExternalValidInterfaceParam;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamMultiImp;
use Cag\Spec\Mock\ClassForProvider\WithInterfaceParamOneImp;
use Cag\Spec\Mock\ClassForProvider\WithSimpleClassParam;
use Cag\Spec\Mock\ClassForProvider\WithStringParam;
use Cag\Tests\Containers\Config\ComposerAbstract;

describe(
    message: 'Specification to Container\DependencyInjection',
    closure: function () {
        beforeAll(closure: function () {ComposerAbstract::autoload();});
        beforeEach(
            /**
             * @throws ReflectionException
             * @throws DefinitionException
             * @throws ComposerException
             * @throws NotFoundException
             */
            closure: function () {
                $path = str_replace(
                    search: 'spec/Containers',
                    replace: 'tests/Containers/Config',
                    subject: __DIR__
                );
                $path .= '/container.yml';
                $this->di = new DependencyInjection(
                    container: new ExternalDependencyInjection(),
                    path: $path
                );
            }
        );

        describe(
            message: 'Specification to has methode',
            closure: function () {
                it(
                    message: 'should has a simple class with no param (autowire)',
                    closure: function () {
                        expect(
                            actual: $this->di->has(id: Simple::class)
                        )->toBeTruthy();
                        expect(
                            actual: $this->di->get(id: Simple::class)
                        )->toBeAnInstanceOf(expected: Simple::class);
                        expect(
                            actual: $this->di->aggregate->has(param: Simple::class)
                        )->toBeTruthy();
                    }
                );
                with_provided_data_it(
                    message: "should instantiate a class with {:0}",
                    closure: function($message, $class) {
                        expect(
                            actual: $this->di->get(id: $class)
                        )->toBeAnInstanceOf(expected: $class);
                    },
                    provider: function () {
                        yield [
                            'internal class (simple) param (autowire)',
                            WithSimpleClassParam::class
                        ];
                        yield [
                            'interface (external) param (autowire)',
                            WithExternalValidInterfaceParam::class
                        ];
                        yield [
                            'internal interface param (one imp) (autowire)',
                            WithInterfaceParamOneImp::class
                        ];
                        yield [
                            'internal interface param (multiple imp) (configwire)',
                            WithInterfaceParamMultiImp::class
                        ];
                        yield [
                            'internal class param who have string param',
                            WithComplexeClassParam::class
                        ];
                    }
                );

                it(
                    message: 'should not instantiate a class with class (external) param (autowire)',
                    closure: function () {
                        try {
                            $this->di->get(id: WithExternalClassParam::class);
                        } catch (NotFoundException $e) {
                            expect(
                                actual: $e->getMessage())->toBe(
                                expected: sprintf(
                                    DependencyInjection::LOG_NOT_FOUND,
                                    WithExternalClassParam::class
                                )
                            );
                            expect(actual: $e->getCode())->toBe(
                                expected: DependencyInjection::LOG_NOT_FOUND_CODE
                            );
                        }
                    }
                );
                it(
                    message: 'should instantiate a class with string param (configwire)',
                    closure: function () {
                        expect(
                            actual: $this->di->get(
                                id: WithStringParam::class
                            )->param
                        )->toBe(expected: 'test');
                    }
                );
            }
        );
    }
);
