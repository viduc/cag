<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

class ErrorModel extends ModelAbstract
{
    private int $code;
    private string $message;
    private string $redirect;

    public function __construct(
        int $code = null,
        string $mesage = null,
        string $redirect = null
    ) {
        $this->code = $code ?? 0;
        $this->message = $mesage ?? 'erreur';
        $this->redirect = $redirect ?? 'redirect';
    }

    /**
     * @return int
     */
    final public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    final public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    final public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    final public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    final public function getRedirect(): string
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     */
    final public function setRedirect(string $redirect): void
    {
        $this->redirect = $redirect;
    }
}
