<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Draw\tests\Models;

use Modules\Draw\Models\DrawImage;
use Modules\Media\Models\Media;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Draw\Models\DrawImage::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->img->id);
        self::assertNull($this->img->media);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testFromMedia() : void
    {
        $img = DrawImage::fromMedia($temp = new Media());
        self::assertEquals($temp, $img->media);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testSerialize() : void
    {
        self::assertEquals(
            [
                'id'    => 0,
                'media' => null,
            ],
            $this->img->jsonSerialize()
        );
    }
}
