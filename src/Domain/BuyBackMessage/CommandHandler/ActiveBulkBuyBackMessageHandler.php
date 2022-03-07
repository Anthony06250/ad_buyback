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

namespace AdBuyBack\Domain\BuyBackMessage\CommandHandler;

use AdBuyBack\Domain\BuyBackMessage\Command\ActiveBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\ActiveBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Exception\CannotActiveBulkBuyBackMessageException;
use AdBuyBack\Model\BuyBackMessage;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopException;

final class ActiveBulkBuyBackMessageHandler
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
     * @param ActiveBulkBuyBackMessageCommand $command
     * @return void
     */
    public function handle(ActiveBulkBuyBackMessageCommand $command): void
    {
        $messageIds = $command->getId()->getValue();
        $status = (int)$command->getStatus();

        try {
            foreach ($this->getBuyBackMessage($messageIds) as $message) {
                $this->activeBuyBackMessage($message, $status);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBulkBuyBackMessageException($exception->getMessage());
        }
    }

    /**
     * @param array $messageIds
     * @return array
     * @throws PrestaShopException
     */
    private function getBuyBackMessage(array $messageIds): array
    {
        foreach ($messageIds as $key => $messageId) {
            $messageIds[$key] = new BuyBackMessage($messageId);
        }

        return $messageIds;
    }

    /**
     * @param BuyBackMessage $message
     * @param int $status
     * @return void
     */
    private function activeBuyBackMessage(BuyBackMessage $message, int $status): void
    {
        if ($message->active != $status) {
            $this->commandBus->handle(new ActiveBuyBackMessageCommand($message->id));
        }
    }
}
