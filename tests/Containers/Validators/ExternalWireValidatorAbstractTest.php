<?php
declare(strict_types=1);
/**
 * CAG - Clean Architecture Generator
 *
 * Tristan Fleury <http://viduc.github.com/>
 *
 * Licence: GPL v3 https://opensource.org/licenses/gpl-3.0.html
 */

namespace Cag\Tests\Containers\Validators;

use Cag\Containers\Validators\ExternalWireValidatorAbstract;
use PHPUnit\Framework\TestCase;

class ExternalWireValidatorAbstractTest extends TestCase
{
    private ExternalWireValidatorAbstract $validator;

    public function testValidInterface(): void
    {
        $this->assertFalse(
            condition: ExternalWireValidatorAbstract::validInterface(class: 'test')
        );
    }
}