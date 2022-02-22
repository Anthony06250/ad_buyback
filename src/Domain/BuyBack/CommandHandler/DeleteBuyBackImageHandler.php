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

use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackImageCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDeleteBuyBackImageException;
use AdBuyBack\Model\BuyBackImage;
use PrestaShopException;

final class DeleteBuyBackImageHandler
{
    /**
     * @param DeleteBuyBackImageCommand $command
     * @return void
     */
    public function handle(DeleteBuyBackImageCommand $command): void
    {
        $id = $command->getId()->getValue();

        try {
            if (!(new BuyBackImage($id))->delete()) {
                throw new CannotDeleteBuyBackImageException(sprintf('Failed to delete buy back image with id "%s"', $id));
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBuyBackImageException('An unexpected error occurred when delete buy back image');
        }
    }
}
