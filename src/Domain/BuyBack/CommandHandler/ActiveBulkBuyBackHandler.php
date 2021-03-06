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

use AdBuyBack\Domain\BuyBack\Command\ActiveBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\ActiveBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotActiveBulkBuyBackException;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopException;

final class ActiveBulkBuyBackHandler
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
     * @param ActiveBulkBuyBackCommand $command
     * @return void
     */
    public function handle(ActiveBulkBuyBackCommand $command): void
    {
        $buybackIds = $command->getId()->getValue();
        $status = (int)$command->getStatus();

        try {
            foreach ($this->getBuyBack($buybackIds) as $buyback) {
                $this->activeBuyBack($buyback, $status);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBulkBuyBackException($exception->getMessage());
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
     * @param BuyBack $buyBack
     * @param int $status
     * @return void
     */
    private function activeBuyBack(BuyBack $buyBack, int $status): void
    {
        if ($buyBack->active != $status) {
            $this->commandBus->handle(new ActiveBuyBackCommand($buyBack->id));
        }
    }
}
