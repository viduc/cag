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

namespace Cag\Spec\Containers;

use Cag\Containers\DependencyInjectionInterface;
use Cag\Spec\Mock\ClassForProvider\Interfaces\Dependencies\ExternalDependenceInterface;
use External\ImpExternalDependenceInterface;
use ReflectionClass;

class ExternalDependencyInjection implements DependencyInjectionInterface
{
    /**
     * @var string[]
     */
    private array $list = [
        ExternalDependenceInterface::class => ImpExternalDependenceInterface::class
    ];

    /**
     * @inheritDoc
     */
    public function get(string $id): mixed
    {
        $reflection = new ReflectionClass($this->list[$id]);
        return $reflection->newInstance();
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return array_key_exists($id, $this->list);
    }
}
