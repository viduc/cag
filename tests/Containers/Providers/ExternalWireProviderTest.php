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

namespace Cag\Tests\Containers\Providers;

use Cag\Containers\Exceptions\ComposerException;
use Cag\Containers\Exceptions\DefinitionException;
use Cag\Containers\Providers\ExternalWireProvider;
use Cag\Spec\Mock\ClassForProvider\Interfaces\Dependencies\ExternalDependenceInterface;
use Cag\Spec\Mock\ClassForProvider\Interfaces\WithOneImpInterface;
use Cag\Tests\Containers\Config\ComposerAbstract;
use PHPUnit\Framework\TestCase;

class ExternalWireProviderTest extends TestCase
{
    /**
     * @var ExternalWireProvider
     */
    private ExternalWireProvider $provider;

    public function setUp(): void
    {
        parent::setUp();
        ComposerAbstract::autoload();
        $this->provider = new ExternalWireProvider();
    }

    /**
     * @return void
     */
    public function testProvideInterface(): void
    {
        self::assertTrue(
            $this->provider->provides(ExternalDependenceInterface::class)
        );
    }

    /**
     * @return void
     * @throws DefinitionException
     * @throws ComposerException
     */
    public function testRegister(): void
    {
        $this->provider->register();
        self::assertTrue(
            $this->provider->getAggregate()->has(
                ExternalDependenceInterface::class
            )
        );
        self::assertFalse(
            $this->provider->getAggregate()->has(
                WithOneImpInterface::class
            )
        );
    }
}
