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

use AdBuyBack\Domain\BuyBack\Command\DuplicateBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDuplicateBulkBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShopException;

final class DuplicateBulkBuyBackHandler
{
    /**
     * @param DuplicateBulkBuyBackCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackCommand $command): void
    {
        $buybackIds = $command->getId()->getValue();

        try {
            $this->duplicateBuyBack($buybackIds);
        } catch (PrestaShopException $exception) {
            throw new CannotDuplicateBulkBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param array $buybackIds
     * @return void
     * @throws PrestaShopException
     */
    private function duplicateBuyBack(array $buybackIds): void
    {
        if (!(new BuyBack())->duplicateSelection($buybackIds)) {
            throw new CannotDuplicateBulkBuyBackException(sprintf('Failed to duplicate buy backs with ids "%s"', implode(', ', $buybackIds)));
        }
    }
}
