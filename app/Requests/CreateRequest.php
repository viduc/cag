<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace App\Requests;

use Cag\Exceptions\NotFoundException;
use Cag\Requests\RequestInterface;

class CreateRequest implements RequestInterface
{
    /**
     * @var array
     */
    private $param = [];

    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return 'create';
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function addParam(string $key, string $value): void
    {
        $this->param[$key] = $value;
    }

    /**
     * @inheritDoc
     */
    public function getParam(string $param): mixed
    {
        if (isset($this->param[$param])) {
            return $this->param[$param];
        }
        throw new NotFoundException(
            'Param: '.$param.' not found',
            101
        );
    }
}
