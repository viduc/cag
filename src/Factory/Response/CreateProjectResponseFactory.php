<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Factory\Response;

use Cag\Responses\CreateProjectResponse;
use Cag\Responses\ResponseInterface;

class CreateProjectResponseFactory extends CreateProjectResponseFactoryAbstract
{
    public function createResponse(): ResponseInterface
    {
        return new CreateProjectResponse();
    }
}
