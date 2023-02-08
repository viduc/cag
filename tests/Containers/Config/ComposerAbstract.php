<?php
declare(strict_types=1);
/**
 * This file is part of the Cag package.
 *
 * (c) GammaSoftware <http://www.winlassie.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cag\Tests\Containers\Config;

abstract class ComposerAbstract
{
    /**
     * @return void
     */
    public static function autoload(): void
    {
        $path = str_replace(
            'tests/Containers/Config',
            '',
            __DIR__
        );

        exec('cd '.$path.' | composer dump-autoload');
    }
}
