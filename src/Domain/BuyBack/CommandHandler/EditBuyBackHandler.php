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

use AdBuyBack\Domain\BuyBack\Command\EditBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotEditBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShopException;

final class EditBuyBackHandler extends ImageBuyBackHandler
{
    /**
     * @param EditBuyBackCommand $command
     * @return void
     */
    public function handle(EditBuyBackCommand $command): void
    {
        $buybackId = $command->getId()->getValue();
        $images = $command->getImage();

        try {
            $buyback = new BuyBack($buybackId);

            $buyback->hydrate($command->toArray());
            $this->editBuyBack($buyback);
            $this->uploadImages($buyback->id, $images);
        } catch (PrestaShopException $exception) {
            throw new CannotEditBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     * @throws PrestaShopException
     */
    private function editBuyBack(BuyBack $buyback): void
    {
        if (!$buyback->update()) {
            throw new CannotEditBuyBackException(sprintf('Failed to update buy back with id "%s"', $buyback->id));
        }
    }
}
