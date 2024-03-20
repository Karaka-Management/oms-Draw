<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
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
     * @covers \Modules\Draw\Models\NullDrawImage
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Draw\Models\DrawImage', new NullDrawImage());
    }

    /**
     * @covers \Modules\Draw\Models\NullDrawImage
     * @group module
     */
    public function testId() : void
    {
        $null = new NullDrawImage(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers \Modules\Draw\Models\NullDrawImage
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullDrawImage(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
