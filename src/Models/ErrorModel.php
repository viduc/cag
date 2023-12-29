<?php

declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator.
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Models;

class ErrorModel extends ModelAbstract
{
    public function __construct(
        private int|null $code = null,
        private string|null $message = null,
        private string|null $redirect = null
    ) {
        $this->code = $code ?? 0;
        $this->message = $message ?? 'erreur';
        $this->redirect = $redirect ?? 'redirect';
    }

    final public function getCode(): int
    {
        return $this->code;
    }

    final public function setCode(int $code): void
    {
        $this->code = $code;
    }

    final public function getMessage(): string
    {
        return $this->message;
    }

    final public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    final public function getRedirect(): string
    {
        return $this->redirect;
    }

    final public function setRedirect(string $redirect): void
    {
        $this->redirect = $redirect;
    }
}
