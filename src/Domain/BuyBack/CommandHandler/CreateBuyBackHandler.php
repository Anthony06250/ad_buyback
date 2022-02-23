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

use AdBuyBack\Domain\BuyBack\Command\CreateBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotCreateBuyBackException;
use AdBuyBack\Domain\BuyBack\ValueObject\BuyBackId;
use AdBuyBack\Model\BuyBack;
use PrestaShopException;

final class CreateBuyBackHandler extends ImageBuyBackHandler
{
    /**
     * @param CreateBuyBackCommand $command
     * @return BuyBackId
     */
    public function handle(CreateBuyBackCommand $command): BuyBackId
    {
        $images = $command->getImage();

        try {
            $buyback = new BuyBack();

            $buyback->hydrate($command->toArray());
            $this->createBuyBack($buyback);
            $this->uploadImages((int)$buyback->id, $images);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$buyback->id);
    }

    /**
     * @param BuyBack $buyback
     * @return void
     * @throws PrestaShopException
     */
    private function createBuyBack(BuyBack &$buyback): void
    {
        if (!$buyback->add()) {
            throw new CannotCreateBuyBackException('Failed to create buy back');
        }
    }
}
