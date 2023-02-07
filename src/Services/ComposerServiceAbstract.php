<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Services;

abstract class ComposerServiceAbstract implements ServiceInterface
{
    /**
     * @param string $key
     * @param array $value
     * @return void
     */
    public abstract function addAutoload(string $key, array $value): void;
}
