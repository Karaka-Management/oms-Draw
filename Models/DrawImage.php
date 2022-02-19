<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Draw\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Draw\Models;

use Modules\Media\Models\Media;
use phpOMS\Contract\ArrayableInterface;

/**
 * News article class.
 *
 * @package Modules\Draw\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class DrawImage implements \JsonSerializable, ArrayableInterface
{
    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Media object.
     *
     * @var null|int|Media
     * @since 1.0.0
     */
    public null|int|Media $media = null;

    /**
     * Get id
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

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
    public function jsonSerialize()
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
