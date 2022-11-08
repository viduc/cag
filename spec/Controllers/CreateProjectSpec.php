<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

use Cag\Controllers\CreateProject;
use Spec\Implentation\Containers\Container;
use Spec\Implentation\Presenters\CreateProjectPresenter;
use Spec\Implentation\Requests\CreateProjectRequest;

describe('CreateProject', function () {
    describe('->execute', function () {
        beforeEach(function () {
            $this->createProject = new CreateProject(new Container());
        });
    });
});
