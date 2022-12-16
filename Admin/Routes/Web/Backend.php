<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Draw\Controller\BackendController;
use Modules\Draw\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/draw/create.*$' => [
        [
            'dest'       => '\Modules\Draw\Controller\BackendController:setUpDrawEditor',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::DRAW,
            ],
        ],
        [
            'dest'       => '\Modules\Draw\Controller\BackendController:viewDrawCreate',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::DRAW,
            ],
        ],
    ],
    '^.*/draw/list.*$' => [
        [
            'dest'       => '\Modules\Draw\Controller\BackendController:viewDrawList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::DRAW,
            ],
        ],
    ],
    '^.*/draw/single.*$' => [
        [
            'dest'       => '\Modules\Draw\Controller\BackendController:setUpDrawEditor',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::DRAW,
            ],
        ],
        [
            'dest'       => '\Modules\Draw\Controller\BackendController:viewDrawSingle',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::DRAW,
            ],
        ],
    ],
];
