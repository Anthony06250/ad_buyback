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

namespace AdBuyBack\Domain\BuyBackChat\CommandHandler;

use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Exception\CannotActiveBulkBuyBackChatException;
use AdBuyBack\Model\BuyBackChat;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopException;

final class ActiveBulkBuyBackChatHandler
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
     * @param ActiveBulkBuyBackChatCommand $command
     * @return void
     */
    public function handle(ActiveBulkBuyBackChatCommand $command): void
    {
        $chatIds = $command->getId()->getValue();
        $status = (int)$command->getStatus();
        $isActive = $command->getIsActive();
        $errors = [];

        try {
            foreach ($this->getBuyBackChat($chatIds) as $chat) {
                $this->activeBuyBackChat($chat, $status, $isActive, $errors);
            }
            if ($errors) {
                throw new CannotActiveBulkBuyBackChatException(implode('<br>', $errors));
            }
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBulkBuyBackChatException($exception->getMessage());
        }
    }

    /**
     * @param array $chatIds
     * @return array
     * @throws PrestaShopException
     */
    private function getBuyBackChat(array $chatIds): array
    {
        foreach ($chatIds as $key => $chatId) {
            $chatIds[$key] = new BuyBackChat($chatId);
        }

        return $chatIds;
    }

    /**
     * @param BuyBackChat $chat
     * @param int $status
     * @param array $errors
     * @return void
     */
    private function activeBuyBackChat(BuyBackChat $chat, int $status, bool $isActive, array &$errors): void
    {
        if ($chat->active != $status) {
            try {
                $this->commandBus->handle(new ActiveBuyBackChatCommand($chat->id, $isActive));
            } catch (BuyBackException $exception) {
                $errors[] = $exception->getMessage();
            }
        }
    }
}
