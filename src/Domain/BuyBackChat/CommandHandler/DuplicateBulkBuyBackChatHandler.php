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

use AdBuyBack\Domain\BuyBackChat\Command\DuplicateBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Exception\CannotDuplicateBulkBuyBackChatException;
use AdBuyBack\Domain\BuyBackMessage\Command\DuplicateBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForChat;
use AdBuyBack\Model\BuyBackChat;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DuplicateBulkBuyBackChatHandler
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param CommandBusInterface $commandBus
     * @param TranslatorInterface $translator
     */
    public function __construct(CommandBusInterface $commandBus, TranslatorInterface $translator)
    {
        $this->commandBus = $commandBus;
        $this->translator = $translator;
    }

    /**
     * @param DuplicateBulkBuyBackChatCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackChatCommand $command): void
    {
        $chatIds = $command->getId()->getValue();
        $buybackId = $command->getBuybackId();

        try {
            foreach ($this->getBuyBackChat($chatIds) as $chat) {
                $this->duplicateBuyBackChat($chat, $buybackId);
                $this->duplicateBuyBackMessage($chat);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDuplicateBulkBuyBackChatException($exception->getMessage());
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
     * @param int|null $buybackId
     * @return void
     * @throws PrestaShopException
     */
    private function duplicateBuyBackChat(BuyBackChat &$chat, ?int $buybackId): void
    {
        $oldId = $chat->id;
        $chat = $chat->duplicateObject();
        $chat->oldId = $oldId;

        if ($buybackId) {
            $chat->id_ad_buyback = $buybackId;
        }

        if (!$chat->save()) {
            throw new CannotDuplicateBulkBuyBackChatException($this->translator->trans(
                'Failed to duplicate chat with id %chatId%.',
                ['%chatId%' => $chat->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBackChat $chat
     * @return void
     */
    private function duplicateBuyBackMessage(BuyBackChat $chat): void
    {
        if ($messages = $this->commandBus->handle(new GetMessageForChat($chat->oldId ?? $chat->id))->getData()) {
            foreach ($messages as $key => $message) {
                $messages[$key] = $message['id_ad_buyback_message'];
            }

            $this->commandBus->handle(new DuplicateBulkBuyBackMessageCommand($messages, (int)$chat->id));
        }
    }
}
