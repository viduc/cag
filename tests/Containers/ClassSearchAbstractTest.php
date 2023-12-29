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

namespace Cag\Tests\Containers;

use Cag\Containers\ClassSearchAbstract;
use Cag\Containers\Exceptions\ComposerException;
use Cag\Tests\Containers\Config\ComposerAbstract;
use PHPUnit\Framework\TestCase;

class ClassSearchAbstractTest extends TestCase
{
    /**
     * @return void
     */
    #[\Override]
    public function setUp(): void
    {
        ComposerAbstract::autoload();
    }

    /**
     * @throws ComposerException
     */
    public function testGetAllClass(): void
    {
        self::assertIsArray(actual: ClassSearchAbstract::getAllClass());
    }
}
