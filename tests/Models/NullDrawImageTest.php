<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Draw\tests\Models;

use Modules\Draw\Models\NullDrawImage;

/**
 * @internal
 */
final class NullDrawImageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Draw\Models\NullDrawImage
     * @group framework
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Draw\Models\DrawImage', new NullDrawImage());
    }

    /**
     * @covers Modules\Draw\Models\NullDrawImage
     * @group framework
     */
    public function testId() : void
    {
        $null = new NullDrawImage(2);
        self::assertEquals(2, $null->getId());
    }
}
