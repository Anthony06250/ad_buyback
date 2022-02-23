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

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBackImage\Command\CreateBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Query\GetImageForBuyBack;
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
        $name = $image->getClientOriginalName();

        BuyBackTools::createDirectory($directory);
        $this->uploadFromTemp($temporaryName, $directory . $name);
        $this->createNewImage($id, $name);
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
     * @return void
     * @throws ImageOptimizationException
     * @throws MemoryLimitException
     */
    protected function uploadFromTemp(string $temporaryName, string $destination): void
    {
        if (!ImageManager::checkImageMemoryLimit($temporaryName)) {
            throw new MemoryLimitException('Cannot upload image due to memory restrictions');
        }

        if (!ImageManager::resize($temporaryName, $destination)) {
            throw new ImageOptimizationException('An error occurred while uploading the image. Check your directory permissions.');
        }

        unlink($temporaryName);
    }

    /**
     * @param int $buybackId
     * @param string $name
     * @return void
     */
    private function createNewImage(int $buybackId, string $name): void
    {
        // Use custom kernel for front office
        $handler = Ad_BuyBack::getService('prestashop.core.command_bus');
        $images = $handler->handle(new GetImageForBuyBack($buybackId))->getData();

        foreach ($images as $image) {
            if (in_array($name, $image, true)) {
                return;
            }
        }

        $handler->handle((new CreateBuyBackImageCommand())->fromArray(['id_ad_buyback' => $buybackId, 'name' => $name]));
    }
}
