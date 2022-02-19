<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Draw
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Draw\Controller;

use Modules\Draw\Models\DrawImageMapper;
use phpOMS\Asset\AssetType;
use phpOMS\Contract\RenderableInterface;
use phpOMS\DataStorage\Database\Query\OrderType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Calendar controller class.
 *
 * @package Modules\Draw
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function setUpDrawEditor(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        /** @var \phpOMS\Model\Html\Head $head */
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::JSLATE, 'Modules/Draw/Controller.js');
        $head->addAsset(AssetType::JSLATE, 'Modules/Draw/Models/DrawType.js');
        $head->addAsset(AssetType::JSLATE, 'Modules/Draw/Models/Editor.js');
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        /** @var \Modules\Draw\Models\DrawImage $draw */
        $draw      = DrawImageMapper::get()->where('id', (int) ($request->getData('id')))->execute();
        $accountId = $request->header->account;

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        $view->addData('image', $draw);

        return $view;
    }

    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawList(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        /** @var \Modules\Draw\Models\DrawImage[] $images */
        $images = DrawImageMapper::getAll()->sort('id', OrderType::DESC)->limit(25);
        $view->addData('images', $images);

        return $view;
    }
}
