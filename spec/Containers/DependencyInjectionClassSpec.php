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
    'Specification to Container\DependencyInjection',
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
                $this->di = new DependencyInjection(
                    new ExternalDependencyInjection(),
                    $path
                );
            }
        );

        describe(
            'Specification to has methode',
            function () {
                it(
                    'should has a simple class with no param (autowire)',
                    function () {
                        expect(
                            $this->di->has(Simple::class)
                        )->toBeTruthy();
                        expect(
                            $this->di->get(Simple::class)
                        )->toBeAnInstanceOf(Simple::class);
                        expect(
                            $this->di->aggregate->has(Simple::class)
                        )->toBeTruthy();
                    }
                );
                it(
                    'should instantiate a class with internal class (simple) param (autowire)',
                    function () {
                        expect(
                            $this->di->get(WithSimpleClassParam::class)
                        )->toBeAnInstanceOf(WithSimpleClassParam::class);
                    }
                );
                it(
                    'should instantiate a class with interface (external) param (autowire)',
                    function () {
                        expect(
                            $this->di->get(WithExternalValidInterfaceParam::class)
                        )->toBeAnInstanceOf(WithExternalValidInterfaceParam::class);
                    }
                );
                it(
                    'should not instantiate a class with class (external) param (autowire)',
                    function () {
                        try {
                            $this->di->get(WithExternalClassParam::class);
                        } catch (NotFoundException $e) {
                            expect($e->getMessage())->toBe(
                                sprintf(
                                    DependencyInjection::LOG_NOT_FOUND,
                                    WithExternalClassParam::class
                                )
                            );
                            expect($e->getCode())->toBe(
                                DependencyInjection::LOG_NOT_FOUND_CODE
                            );
                        }
                    }
                );
                it(
                    'should instantiate a class with internal interface param (one imp) (autowire)',
                    function () {
                        expect(
                            $this->di->get(WithInterfaceParamOneImp::class)
                        )->toBeAnInstanceOf(WithInterfaceParamOneImp::class);
                    }
                );
                it(
                    'should provide a class with string param (configwire)',
                    function () {
                        expect(
                            $this->di->get(WithStringParam::class)->param
                        )->toBe('test');
                    }
                );
                it(
                    'should provide a class with internal interface param (multiple imp) (configwire)',
                    function () {
                        expect(
                            $this->di->get(WithInterfaceParamMultiImp::class)
                        )->toBeAnInstanceOf(WithInterfaceParamMultiImp::class);
                    }
                );
                it(
                    'should provide a class with internal class param who have string param',
                    function () {
                        expect(
                            $this->di->get(WithComplexeClassParam::class)
                        )->toBeAnInstanceOf(WithComplexeClassParam::class);
                    }
                );
            }
        );
    }
);
