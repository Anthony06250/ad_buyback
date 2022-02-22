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

use AdBuyBack\Domain\BuyBack\Command\DeleteBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDeleteBulkBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShopException;

final class DeleteBulkBuyBackHandler
{
    /**
     * @param DeleteBulkBuyBackCommand $command
     * @return void
     */
    public function handle(DeleteBulkBuyBackCommand $command): void
    {
        $ids = $command->getId()->getValue();

        try {
            if (false === (new BuyBack())->deleteSelection($ids)) {
                throw new CannotDeleteBulkBuyBackException(
                    sprintf('Failed to delete buy backs with ids "%s"', implode(', ', $ids))
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBulkBuyBackException(
                'An unexpected error occurred when delete buy backs'
            );
        }
    }
}
