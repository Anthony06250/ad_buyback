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

use AdBuyBack\Domain\BuyBack\Command\ToggleActiveBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotToggleStatusBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShopException;

final class ToggleActiveBuyBackHandler
{
    /**
     * @param ToggleActiveBuyBackCommand $command
     * @return void
     */
    public function handle(ToggleActiveBuyBackCommand $command): void
    {
        $id = $command->getId()->getValue();

        try {
            if (false === (new BuyBack($id))->toggleStatus()) {
                throw new CannotToggleStatusBuyBackException(
                    sprintf('Failed to toggle status for buy back with id "%s"', $id)
                );
            }
        } catch (PrestaShopException $exception) {
            throw new CannotToggleStatusBuyBackException(
                'An unexpected error occurred when toggle status of buy back'
            );
        }
    }
}
