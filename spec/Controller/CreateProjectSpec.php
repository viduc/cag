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
use Spec\Implentation\DependencyInjection\Container;
use Spec\Implentation\Presenter\CreateProjectPresenter;
use Spec\Implentation\Requete\CreateProjectRequete;

describe('CreateProject', function () {
    describe('->execute', function () {
        beforeEach(function () {
            $this->createProject = new CreateProject(new Container());
        });
        it('devrait retourner une Reponse contenant un StructureModel
            ayant comme attribut name "test"',
            function () {
                $execute = $this->createProject->execute(
                    new CreateProjectRequete('action', ['name' => 'test']),
                    new CreateProjectPresenter()
                )->getReponse()->getStructureModel()->getName();
                expect($execute)->toBe("test");
            }
        );
    });
});
