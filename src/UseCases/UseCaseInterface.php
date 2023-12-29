<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\UseCases;

use Cag\Presenters\PresenterInterface;
use Cag\Requests\RequestInterface;

interface UseCaseInterface
{
    /**
     * @param RequestInterface   $request
     * @param PresenterInterface $presenter
     *
     * @return PresenterInterface
     */
    public function execute(
        RequestInterface   $request,
        PresenterInterface $presenter
    ): PresenterInterface;
}
