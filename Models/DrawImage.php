<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Draw\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Draw\Models;

use Modules\Media\Models\Media;

/**
 * News article class.
 *
 * @package Modules\Draw\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class DrawImage implements \JsonSerializable
{
    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Media object.
     *
     * @var null|int|Media
     * @since 1.0.0
     */
    public null|int|Media $media = null;

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'    => $this->id,
            'media' => $this->media,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }

    /**
     * Create Image from media
     *
     * @param Media $media Media object
     *
     * @return DrawImage
     *
     * @since 1.0.0
     */
    public static function fromMedia(Media $media) : self
    {
        $image        = new self();
        $image->media = $media;

        return $image;
    }
}
