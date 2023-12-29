<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Factory\Model\StructureModelFactory;
use Cag\Factory\Response\CreateProjectResponseFactory;
use Cag\Models\StructureModel;
use Cag\Presenters\PresenterInterface;
use Cag\Services\ComposerService;
use Cag\Services\FolderService;
use Cag\Services\StructureService;
use Cag\UseCases\CreateProjectUseCase;
use Cag\Spec\Implentation\Presenters\CreateProjectPresenter;
use Cag\Spec\Implentation\Requests\CreateProjectRequest;

describe(
    message: 'CreateProjectUseCase',
    closure: function () {
        beforeEach(
            closure: function () {
                $this->folderService = new FolderService();
                $this->structureService = new StructureService(
                    folderService: $this->folderService
                );
                $this->composerService = new ComposerService();
                $this->structureModelFactory = new StructureModelFactory();
                $this->createProjectResponseFactory = new CreateProjectResponseFactory();
                $this->createProject = new CreateProjectUseCase(
                $this->structureService,
                $this->composerService,
                $this->structureModelFactory,
                $this->createProjectResponseFactory
                );
        });
        describe(
            message: 'Execution of Use Case',
            closure: function () {
            it( message: 'should return a Presenter Interface',
                /**
                 * @throws Exception
                 */
                closure: function () {
                    allow(actual: StructureModelFactory::class)->toReceive(
                        'getStandard'
                    )->andReturn(new StructureModel(srcName: 'test'));
                    allow(actual: StructureService::class)->toReceive(
                        'create'
                    )->andReturn(null);
                    allow(actual: ComposerService::class)->toReceive(
                        'addAutoload'
                    )->andReturn(null);
                    expect(
                        actual: $this->createProject->execute(
                            request: new CreateProjectRequest(
                                action: 'test',
                                params: ['name' => 'test']
                            ),
                            presenter: new CreateProjectPresenter()
                        )
                    )->toBeAnInstanceOf(expected: PresenterInterface::class);
                }
            );
        }
    );
});
