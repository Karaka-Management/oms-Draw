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

namespace Modules\Draw\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Utils\TestUtils;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Draw\Controller\ApiController::class)]
#[\PHPUnit\Framework\Attributes\TestDox('Modules\Draw\tests\Controller\ApiControllerTest: Draw api controller')]
final class ApiControllerTest extends \PHPUnit\Framework\TestCase
{
    protected ApplicationAbstract $app;

    /**
     * @var \Modules\Draw\Controller\ApiController
     */
    protected ModuleAbstract $module;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $this->app->dbPool         = $GLOBALS['dbpool'];
        $this->app->unitId         = 1;
        $this->app->accountManager = new AccountManager($GLOBALS['session']);
        $this->app->appSettings    = new CoreSettings();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../../../Modules/');
        $this->app->dispatcher     = new Dispatcher($this->app);
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../../Web/Api/Hooks.php');
        $this->app->sessionManager = new HttpSession(36000);
        $this->app->l11nManager    = new L11nManager();

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission       = new AccountPermission();
        $permission->unit = 1;
        $permission->app  = 2;
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('Draw');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testCreateDraw() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('title', 'Draw Title');
        $request->setData('image', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABIkAAACbCAYAAADm48vbAAAgAElEQVR4nOyddbiU5faGbzCwwD6KAbZii9hiYItYmNiBinpQsbDj2InFURGVUlEMEAvFbo6CGFigKGJggYXJ749n5rdnb2b2nvhy5rmva1/Kjpl3Zr7vjWet9SwwxiSdlsAbQK+4B2KMMcYYY4wxxhhj4qELMANoH/dAjDHGGGOMMcYYY0w8XA2MiHsQxhhjjDHGGGOMMSYeXF5mjDHGGGOMMcYYU+O4vMwYY4wxxhhjjDGmxnF5mTHGGGOMMcYYY0wN0wqXlxljjDHGGGOMMcbUNLsC03F5mTHGGGOMMcYYY0zNcg0wPO5BGGOMMcYYY4wxxph4aAW8CZwU90CMMcYYY4wxxhhjTDxky8vWi3sgxhhjjDHGGGOMMSYeXF5mjDHGGGOMMcYYU8O4vMwYY4wxxhhjjDGmxnF5mTHGGGOMMcYYY0yNcy0uLzPGGGOMMcYYY4ypWRYExgInxj0QY4wxxhhjjDHGGBMPuwE/AuvGPRBjjDHGGGOMMcYYEw/XAg/FPQhjjDHGGGOMMcYYEw8uLzPGGGOMMcYYY4ypcVxeZowxxhhjjDHGGFPjuLzMGGOMMcYYY4wxpoZphcvLjDHGGGOMMcYYUySt4x6ACYXOwDO4vMwYY4wxxhhjjDFFsgEwNO5BmEC5FBgZ9yCMMcYYY4wxxhiTPvYB/gH2insgpmJeAHrHPQhjjDHGGGOMMcakl2bAfTirKK1sDszK/NcYY4wxxhhjjDGmYrJZRbvEPRBTNL1RBpExxhhjjDHGGGNMoDQDrsNZRWlgJPIgMsYYY4wxxhhjjAkNexUll7WA6aiLmTHGGGOMMcYYY0zo2KsoefQAxgOt4h6IMcYYY4wxxhhjag9nFSWDIUDfuAdhjDHGGGMSx/LA+jlfK8Y7HGOMMdWOs4riow3wGdAt7oEYY4wxxphEsQHanz8M/C/n6wVg4xjHZYwxpk');

        $this->module->apiDrawCreate($request, $response);

        self::assertEquals('Draw Title', $response->getDataArray('')['response']->media->name);
        self::assertGreaterThan(0, $response->getDataArray('')['response']->id);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testApiDrawCreateInvalidData() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest();

        $request->header->account = 1;
        $request->setData('invalid', '1');

        $this->module->apiDrawCreate($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
