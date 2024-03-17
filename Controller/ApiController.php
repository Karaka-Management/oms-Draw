<?php

/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Draw
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Draw\Controller;

use Modules\Draw\Models\DrawImage;
use Modules\Draw\Models\DrawImageMapper;
use Modules\Media\Controller\ApiController as MediaController;
use Modules\Media\Models\UploadStatus;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\System\File\Local\File;
use phpOMS\Utils\ImageUtils;

/**
 * Calendar controller class.
 *
 * @package Modules\Draw
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
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
     * @since 1.0.0
     */
    private function validateDrawCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['image'] = !$request->hasData('image'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiDrawCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateDrawCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $path      = MediaController::createMediaPath();
        $extension = 'png';
        $filename  = '';
        $rnd       = '';

        $i = 0;
        do {
            $filename = \sha1(((string) $request->getData('image')) . $rnd);
            $filename .= '.' . $extension;

            $rnd = \mt_rand();

            ++$i;
        } while (\is_file($path . '/' . $filename) && $i < 10000);

        // protection against infinite loop
        if ($i >= 10000) {
            // @codeCoverageIgnoreStart
            $this->createInvalidCreateResponse($request, $response, []);
            return;
            // @codeCoverageIgnoreEnd
        }

        $fullPath = __DIR__ . '/../../../' . $path . '/' . $filename;

        $this->createLocalFile($fullPath, (string) $request->getData('image'));

        $status = [
            'path'      => $path,
            'filename'  => $filename,
            'name'      => (string) $request->getData('title'),
            'size'      => File::size($fullPath),
            'extension' => $extension,
            'status'    => UploadStatus::OK,
        ];

        $media = MediaController::createDbEntry($status, $request->header->account);
        $draw  = DrawImage::fromMedia($media);

        $this->createModel($request->header->account, $draw, DrawImageMapper::class, 'draw', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $draw);
    }

    /**
     * Create local image file
     *
     * @param string $outputPath Output path
     * @param string $raw        Base64 encoded image string
     *
     * @return bool
     *
     * @since 1.0.0
     */
    private function createLocalFile(string $outputPath, string $raw) : bool
    {
        $imageData = ImageUtils::decodeBase64Image($raw);
        File::put($outputPath, $imageData);

        return true;
    }
}
