<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Presenters;

use Cag\Presenters\PresenterInterface;
use Cag\Responses\ResponseInterface;

class CreateProjectPresenter implements PresenterInterface
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    /**
     * @inheritDoc
     */
    public function presente(ResponseInterface $reponse): void
    {
        $this->response = $reponse;
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}