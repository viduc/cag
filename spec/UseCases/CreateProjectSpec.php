<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Factory\Model\FileModelFactory;
use Cag\Factory\Model\FolderModelFactory;
use Cag\Factory\Model\StructureModelFactory;
use Cag\Factory\Response\CreateProjectResponseFactory;
use Cag\Models\StructureModel;
use Cag\Presenters\PresenterInterface;
use Cag\Services\ComposerService;
use Cag\Services\FileService;
use Cag\Services\FolderService;
use Cag\Services\StructureService;
use Cag\UseCases\CreateProjectUseCase;
use Cag\Spec\Implentation\Presenters\CreateProjectPresenter;
use Cag\Spec\Implentation\Requests\CreateProjectRequest;

describe('CreateProjectUseCase', function () {
    beforeEach(
        function () {
            $this->folderService = new FolderService();
            $this->fileService = new FileService();
            $this->structureService = new StructureService(
                $this->fileService,
                $this->folderService
            );
            $this->composerService = new ComposerService();
            $this->fileModelFactory = new FileModelFactory();
            $this->folderModelFactory = new FolderModelFactory();
            $this->structureModelFactory = new StructureModelFactory(
                $this->fileModelFactory,
                $this->folderModelFactory
            );
            $this->createProjectResponseFactory = new CreateProjectResponseFactory();
            $this->createProject = new CreateProjectUseCase(
            $this->structureService,
            $this->composerService,
            $this->structureModelFactory,
            $this->createProjectResponseFactory
            );
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
