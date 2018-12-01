<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\Draw
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Modules\Draw\Controller;

use phpOMS\Model\Message\FormValidation;
use Modules\Draw\Models\DrawImage;
use Modules\Draw\Models\DrawImageMapper;
use Modules\Draw\Models\PermissionState;
use Modules\Media\Models\UploadStatus;
use phpOMS\Asset\AssetType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Html\Head;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use Modules\Media\Controller as MediaController;
use phpOMS\System\File\Local\File;
use phpOMS\Utils\ImageUtils;
use phpOMS\Views\View;
use phpOMS\Account\PermissionType;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * Calendar controller class.
 *
 * @package    Modules\Draw
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class ApiController extends Controller
{

    /**
     * Validate draw create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since  1.0.0
     */
    private function validateDrawCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = empty($request->getData('title')))
            || ($val['image'] = empty($request->getData('image')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since  1.0.0
     */
    public function apiDrawCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        if (!empty($val = $this->validateDrawCreate($request))) {
            $response->set('draw_create', new FormValidation($val));

            return;
        }

        $path      = MediaController::createMediaPath();
        $extension = 'png';
        $filename  = '';
        $rnd       = '';

        // todo: implement limit since this could get exploited
        do {
            $filename  = sha1(((string) $request->getData('image')) . $rnd);
            $filename .= '.' . $extension;

            $rnd = mt_rand();
        } while (file_exists($path . '/' . $filename));

        $fullPath = __DIR__ . '/../../' . $path . '/' . $filename;

        $this->createLocalFile($fullPath, (string) $request->getData('image'));

        $status = [
            'path' => $path,
            'filename' => $filename,
            'name' => (string) $request->getData('title'),
            'size' => File::size($fullPath),
            'extension' => $extension,
            'status' => UploadStatus::OK,
        ];

        $media = MediaController::createDbEntry($status, $request->getHeader()->getAccount());
        $draw  = DrawImage::fromMedia($media);

        DrawImageMapper::create($draw);

        $response->set('image', $draw->jsonSerialize());
    }

    /**
     * Create local image file
     *
     * @param string $outputPath Output path
     * @param string $raw        Base64 encoded image string
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function createLocalFile(string $outputPath, string $raw) : bool
    {
        $imageData = ImageUtils::decodeBase64Image($raw);
        File::put($outputPath, $imageData);

        return true;
    }
}