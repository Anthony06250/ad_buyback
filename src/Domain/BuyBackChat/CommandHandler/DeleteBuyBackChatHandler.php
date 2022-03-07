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

use AdBuyBack\Domain\BuyBackChat\Command\DeleteBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Exception\CannotDeleteBuyBackChatException;
use AdBuyBack\Domain\BuyBackMessage\Command\DeleteBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForChat;
use AdBuyBack\Model\BuyBackChat;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DeleteBuyBackChatHandler
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
     * @param DeleteBuyBackChatCommand $command
     * @return void
     */
    public function handle(DeleteBuyBackChatCommand $command): void
    {
        $chatId = $command->getId()->getValue();

        try {
            $chat = new BuyBackChat($chatId);

            $this->deleteBuyBackChat($chat);
            $this->deleteBuyBackMessage((int)$chatId);
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBuyBackChatException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackChat $chat
     * @return void
     * @throws PrestaShopException
     */
    public function deleteBuyBackChat(BuyBackChat $chat): void
    {
        if (!$chat->delete()) {
            throw new CannotDeleteBuyBackChatException($this->translator->trans(
                'Failed to delete chat with id %chatId%.',
                ['%chatId%' => $chat->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param int $chatId
     * @return void
     */
    private function deleteBuyBackMessage(int $chatId): void
    {
        if ($messages = $this->commandBus->handle(new GetMessageForChat($chatId))->getData()) {
            foreach ($messages as $key => $message) {
                $messages[$key] = $message['id_ad_buyback_message'];
            }

            $this->commandBus->handle(new DeleteBulkBuyBackMessageCommand($messages));
        }
    }
}
