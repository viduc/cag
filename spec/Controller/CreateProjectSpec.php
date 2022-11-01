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
use Cag\Presenter\PresenterInterface;
use Implentation\Presenter\PresenterCreateProject;
use Implentation\Requete\RequeteCreateProject;

describe('CreateProject', function () {
    describe('->execute', function () {
        beforeEach(function () {

        });
        it('devrait retourner un Presenter contenant une Reponse',
        function () {
            $createProject = new CreateProject();
            $execute = $createProject->execute(
                new RequeteCreateProject(),
                new PresenterCreateProject()
            );
            expect($execute)->toBeAnInstanceOf(
                PresenterInterface::class
            );
        });
    });
});
