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

namespace Cag\Spec\Mock\ClassForProvider;

class WithStringParam
{
    public $param;
    public function __construct(string $test)
    {
        $this->param = $test;
    }
}
