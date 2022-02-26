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

namespace AdBuyBack\Domain\BuyBack\CommandHandler;

use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Uploader\BuyBackExtraImageUploader;
use PrestaShop\PrestaShop\Core\Image\Exception\ImageException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageBuyBackHandler
{
    /**
     * @param int $buybackId
     * @param array $image
     * @return void
     */
    protected function uploadImages(int $buybackId, array $image): void
    {
        try {
            $uploader = new BuyBackExtraImageUploader();

            foreach ($image as $file) {
                if ($file instanceof UploadedFile) {
                    $uploader->upload($buybackId, $file);
                }
            }
        } catch (ImageException $exception) {
            throw new BuyBackException($exception->getMessage());
        }
    }
}
