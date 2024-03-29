<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Spec\Implentation\Requests;

use Cag\Requests\RequestInterface;

class CreateProjectRequest implements RequestInterface
{
    public string $action;

    public array $params;

    public function __construct(string $action = null, array $params = [])
    {
        $this->action = $action ?? 'create';
        $this->params = $params;
    }

    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return 'create';
    }

    /**
     * @inheritDoc
     */
    public function getParam(string $param): mixed
    {
        if (array_key_exists($param, $this->params)) {
            return $this->params[$param];
        }

        return null;
    }

    public function getUseCase(): string
    {
        return 'test';
    }
}