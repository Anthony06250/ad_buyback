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
use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDeleteBulkBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopException;

final class DeleteBulkBuyBackHandler
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param DeleteBulkBuyBackCommand $command
     * @return void
     */
    public function handle(DeleteBulkBuyBackCommand $command): void
    {
        $buybackIds = $command->getId()->getValue();

        try {
            foreach ($this->getBuyBack($buybackIds) as $buyback) {
                $this->deleteBuyBack($buyback);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBulkBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param array $buybackIds
     * @return array
     * @throws PrestaShopException
     */
    private function getBuyBack(array $buybackIds): array
    {
        foreach ($buybackIds as $key => $buybackId) {
            $buybackIds[$key] = new BuyBack($buybackId);
        }

        return $buybackIds;
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function deleteBuyBack(BuyBack $buyback): void
    {
        $this->commandBus->handle(new DeleteBuyBackCommand($buyback->id));
    }
}
