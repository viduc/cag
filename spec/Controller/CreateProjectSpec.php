<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Controller\CreateProject;
use Cag\Model\StructureModel;
use Cag\Presenter\PresenterInterface;

use Spec\Implentation\Presenter\PresenterCreateProject;
use Spec\Implentation\Requete\RequeteCreateProject;

describe('CreateProject', function () {
    describe('->execute', function () {
        beforeEach(function () {
            $this->createProject = new CreateProject();
        });
        it('devrait retourner un Presenter',
            function () {
                $execute = $this->createProject->execute(
                    new RequeteCreateProject(),
                    new PresenterCreateProject()
                );
                expect($execute)->toBeAnInstanceOf(
                    PresenterInterface::class
                );
            }
        );

        it('devrait retourner une Reponse contenant un StructureModel',
            function () {
                $execute = $this->createProject->execute(
                    new RequeteCreateProject(),
                    new PresenterCreateProject()
                )->getReponse()->getStructureModel();
                expect($execute)->toBeAnInstanceOf(
                    StructureModel::class
                );
            }
        );
    });
});
