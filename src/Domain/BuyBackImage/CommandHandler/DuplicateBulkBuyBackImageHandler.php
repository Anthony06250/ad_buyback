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

namespace AdBuyBack\Domain\BuyBackImage\CommandHandler;

use AdBuyBack\Domain\BuyBackImage\Command\DuplicateBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotDuplicateBulkBuyBackImageException;
use AdBuyBack\Model\BuyBackImage;
use AdBuyBack\Tools\BuyBackTools;
use PrestaShopException;

final class DuplicateBulkBuyBackImageHandler
{
    /**
     * @param DuplicateBulkBuyBackImageCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackImageCommand $command): void
    {
        $imageIds = $command->getId()->getValue();
        $buybackId = $command->getBuybackId();

        try {
            $images = $this->getBuyBackImage($imageIds);

            $this->duplicateBuyBack($images, $buybackId);
            $this->duplicateImageFile($images, $buybackId);
        } catch (PrestaShopException $exception) {
            throw new CannotDuplicateBulkBuyBackImageException($exception->getMessage());
        }
    }

    /**
     * @param array $imageIds
     * @return array
     * @throws PrestaShopException
     */
    private function getBuyBackImage(array $imageIds): array
    {
        foreach ($imageIds as $key => $imageId) {
            $imageIds[$key] = new BuyBackImage($imageId);
        }

        return $imageIds;
    }

    /**
     * @param array $images
     * @param int $buybackId
     * @return void
     */
    private function duplicateBuyBack(array &$images, int $buybackId): void
    {
        foreach ($images as $key => $image) {
            $images[$key] = $image->duplicateObject();

            $buybackId
                ? $this->changeBuyBackImageId($images[$key], $buybackId)
                : $this->changeBuyBackImageName($images[$key]);

            if (!$images[$key]->save()) {
                throw new CannotDuplicateBulkBuyBackImageException(sprintf('Failed to duplicate buy back image with id "%s"', $image->id));
            }
        }
    }

    /**
     * @param BuyBackImage $image
     * @param int $buybackId
     * @return void
     */
    private function changeBuyBackImageId(BuyBackImage &$image, int $buybackId): void
    {
        $image->old_id_ad_buyback = $image->id_ad_buyback;
        $image->id_ad_buyback = $buybackId;
    }

    /**
     * @param BuyBackImage $image
     * @return void
     */
    private function changeBuyBackImageName(BuyBackImage &$image): void
    {
        $file = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $image->id_ad_buyback . '/' . $image->name;
        $image->old_name = $image->name;
        $image->name = BuyBackTools::changeFilenameForCopy($file);
    }

    /**
     * @param array $images
     * @return void
     */
    private function duplicateImageFile(array $images): void
    {
        foreach ($images as $image) {
            $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/';
            $directoryFrom = $directory . ($image->old_id_ad_buyback ?? $image->id_ad_buyback) . '/';
            $directoryTo = $directory . $image->id_ad_buyback . '/';

            if (!file_exists($directoryTo)) {
                BuyBackTools::createDirectory($directoryTo);
            }

            if (!copy($directoryFrom . $image->name, $directoryTo . ($image->old_name ?? $image->name))) {
                throw new CannotDuplicateBulkBuyBackImageException(sprintf('Failed to duplicate image file with id "%s"', $image->id));
            }
        }
    }
}