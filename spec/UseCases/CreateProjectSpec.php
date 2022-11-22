<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Services\ComposerService;
use Cag\UseCases\CreateProjectUseCase;
use Cag\Exceptions\ContainerException;
use Cag\Exceptions\NotFoundException;
use Cag\Factory\StructureModelFactory;
use Cag\Models\StructureModel;
use Cag\Presenters\PresenterInterface;
use Cag\Services\StructureService;
use Spec\Implentation\Containers\Container;
use Spec\Implentation\Presenters\CreateProjectPresenter;
use Spec\Implentation\Requests\CreateProjectRequest;

describe('CreateProjectUseCase', function () {
    beforeEach(/**
     * @throws ContainerException
     * @throws NotFoundException
     */ function () {
        $this->createProject = new CreateProjectUseCase(new Container());
    });
    describe('execute', function () {
        it(
            'should return a Presenter Interface',
            function () {
                allow(StructureModelFactory::class)->toReceive(
                    'getStandard'
                )->andReturn(new StructureModel('test'));
                allow(StructureService::class)->toReceive(
                    'create'
                )->andReturn(null);
                allow(ComposerService::class)->toReceive(
                    'addAutoload'
                )->andReturn(null);
                expect(
                    $this->createProject->execute(
                        new CreateProjectRequest(
                            'test',
                            ['name' => 'test']
                        ),
                        new CreateProjectPresenter()
                    )
                )->toBeAnInstanceOf(PresenterInterface::class);
            }
        );
    });
});
