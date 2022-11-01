<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Implentation\Requete;

use Cag\Requete\RequeteInterface;

class RequeteCreateProject implements RequeteInterface
{
    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return 'test';
    }

    /**
     * @inheritDoc
     */
    public function getParam(string $param): mixed
    {
        return 'test';
    }
}