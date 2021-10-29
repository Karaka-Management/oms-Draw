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

use Modules\Draw\Models\DrawImage;
use Modules\Media\Models\Media;

/**
 * @internal
 */
final class DrawImageTest extends \PHPUnit\Framework\TestCase
{
    private DrawImage $img;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->img = new DrawImage();
    }

    /**
     * @covers Modules\Draw\Models\DrawImage
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->img->getId());
        self::assertNull($this->img->media);
    }

    /**
     * @covers Modules\Draw\Models\DrawImage
     * @group module
     */
    public function testFromMedia() : void
    {
        $img = DrawImage::fromMedia($temp = new Media());
        self::assertEquals($temp, $img->media);
    }

    /**
     * @covers Modules\Draw\Models\DrawImage
     * @group module
     */
    public function testSerialize() : void
    {
        self::assertEquals(
            [
                'id'       => 0,
                'media'    => null,
            ],
            $this->img->jsonSerialize()
        );
    }
}
