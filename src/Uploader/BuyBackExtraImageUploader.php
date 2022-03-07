<?php
/*
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace AdBuyBack\Uploader;

use AdBuyBack\Tools\BuyBackTools;
use ImageManager;
use PrestaShop\PrestaShop\Core\Image\Exception\ImageOptimizationException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\ImageUploadException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\MemoryLimitException;
use PrestaShop\PrestaShop\Core\Image\Uploader\Exception\UploadedImageConstraintException;
use PrestaShop\PrestaShop\Core\Image\Uploader\ImageUploaderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tools;

final class BuyBackExtraImageUploader implements ImageUploaderInterface
{
    /**
     * @param $id
     * @param UploadedFile $image
     * @return void
     * @throws ImageOptimizationException
     * @throws ImageUploadException
     * @throws MemoryLimitException
     * @throws UploadedImageConstraintException
     */
    public function upload($id, UploadedFile $image): void
    {
        $this->checkImageIsAllowedForUpload($image);

        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $id . '/';
        $temporaryName = $this->createTemporaryImage($image);
        $imageName = $image->getClientOriginalName();

        BuyBackTools::createDirectory($directory);
        BuyBackTools::createDirectory($directory . '/thumbnail/');
        $this->uploadFromTemp($temporaryName, $directory, $imageName);
    }

    /**
     * @param UploadedFile $image
     * @return void
     * @throws UploadedImageConstraintException
     */
    protected function checkImageIsAllowedForUpload(UploadedFile $image): void
    {
        $maxFileSize = Tools::getMaxUploadSize();

        if ($maxFileSize > 0 && $image->getSize() > $maxFileSize) {
            throw new UploadedImageConstraintException(sprintf('Max file size allowed is "%s" bytes. Uploaded image size is "%s".', $maxFileSize, $image->getSize()), UploadedImageConstraintException::EXCEEDED_SIZE);
        }

        if (!ImageManager::isRealImage($image->getPathname(), $image->getClientMimeType())
            || !ImageManager::isCorrectImageFileExt($image->getClientOriginalName())
            || preg_match('/\%00/', $image->getClientOriginalName())) { // Prevent null byte injection
            throw new UploadedImageConstraintException(sprintf('Image format "%s", not recognized, allowed formats are: .gif, .jpg, .png', $image->getClientOriginalExtension()), UploadedImageConstraintException::UNRECOGNIZED_FORMAT);
        }
    }

    /**
     * @param UploadedFile $image
     * @return string
     * @throws ImageUploadException
     */
    protected function createTemporaryImage(UploadedFile $image): string
    {
        $temporaryName = tempnam(_PS_TMP_IMG_DIR_, 'PS');

        if (!$temporaryName || !move_uploaded_file($image->getPathname(), $temporaryName)) {
            throw new ImageUploadException('Failed to create temporary image file');
        }

        return $temporaryName;
    }

    /**
     * @param string $temporaryName
     * @param string $destination
     * @param string $name
     * @return void
     * @throws ImageOptimizationException
     * @throws MemoryLimitException
     */
    protected function uploadFromTemp(string $temporaryName, string $destination, string $name): void
    {
        if (!ImageManager::checkImageMemoryLimit($temporaryName)) {
            throw new MemoryLimitException('Cannot upload image due to memory restrictions');
        }

        $imageInfos = getimagesize($temporaryName);
        $error = 0;

        if (!ImageManager::resize($temporaryName, $destination . $name, $imageInfos[0], $imageInfos[1],
            $imageInfos['mime'], false, $error, $imageInfos[0], $imageInfos[0], 10)) {
            throw new ImageOptimizationException('An error occurred while uploading the image. Check your directory permissions.');
        }

        $thumbnailSize = $this->getThumbnailSize($destination . $name);

        if (!ImageManager::resize($temporaryName, $destination . '/thumbnail/' . $name, $thumbnailSize['width'], $thumbnailSize['height'],
            $imageInfos['mime'], false, $error, $imageInfos[0], $imageInfos[1], 10)) {
            throw new ImageOptimizationException('An error occurred while creating thumbnail. Check your directory permissions.');
        }

        unlink($temporaryName);
    }

    /**
     * @param string $image
     * @return void
     */
    private function getThumbnailSize(string $image): array
    {
        $thumbnailSize = getimagesize($image);
        $desiredHeight = 360;
        $maxWidth = 480;
        $width = $thumbnailSize[0] * $desiredHeight / $thumbnailSize[1];
        $height = $thumbnailSize[1] * $maxWidth / $thumbnailSize[0];

        return [
            'width' => min($width, $maxWidth),
            'height' => $width <= $maxWidth ? $desiredHeight : $height
        ];
    }
}
