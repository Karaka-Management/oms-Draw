<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Draw\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Draw\Models;

/**
 * Null draw class.
 *
 * @package Modules\Draw\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class NullDrawImage extends DrawImage
{
    /**
     * Constructor
     *
     * @param int $id Model id
     *
     * @since 1.0.0
     */
    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }
}
