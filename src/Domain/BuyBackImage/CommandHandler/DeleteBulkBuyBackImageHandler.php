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

use AdBuyBack\Domain\BuyBackImage\Command\DeleteBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotDeleteBulkBuyBackImageException;
use AdBuyBack\Model\BuyBackImage;
use PrestaShopException;

final class DeleteBulkBuyBackImageHandler
{
    /**
     * @param DeleteBulkBuyBackImageCommand $command
     * @return void
     */
    public function handle(DeleteBulkBuyBackImageCommand $command): void
    {
        $imageIds = $command->getId()->getValue();

        try {
            foreach ($this->getBuyBackImage($imageIds) as $image) {
                $this->deleteBuyBackImage($image);
                $this->deleteImageFile($image);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBulkBuyBackImageException($exception->getMessage());
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
     * @param BuyBackImage $image
     * @return void
     * @throws PrestaShopException
     */
    private function deleteBuyBackImage(BuyBackImage $image): void
    {
        (new DeleteBuyBackImageHandler())->deleteBuyBackImage($image);
    }

    /**
     * @param BuyBackImage $image
     * @return void
     */
    private function deleteImageFile(BuyBackImage $image): void
    {
        (new DeleteBuyBackImageHandler())->deleteImageFile($image);
    }
}
