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

use AdBuyBack\Domain\BuyBack\Query\GetIsActiveBuyBack;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Exception\CannotActiveBuyBackChatException;
use AdBuyBack\Model\BuyBackChat;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class ActiveBuyBackChatHandler
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
     * @param ActiveBuyBackChatCommand $command
     * @return void
     */
    public function handle(ActiveBuyBackChatCommand $command): void
    {
        $chatId = $command->getId()->getValue();
        $isActive = $command->getIsActive();

        try {
            $chat = new BuyBackChat($chatId);

            $this->activeBuyBackChat($chat, $isActive);
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBuyBackChatException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackChat $chat
     * @param bool $isActive
     * @return void
     * @throws PrestaShopException
     */
    public function activeBuyBackChat(BuyBackChat $chat, bool $isActive): void
    {
        if ($isActive && !$this->commandBus->handle(new GetIsActiveBuyBack($chat->id_ad_buyback))) {
            throw new CannotActiveBuyBackChatException($this->translator->trans(
                'Failed to toggle status of chat with id %chatId% because buyback with id %buybackId% is inactive.',
                [
                    '%chatId%' => $chat->id,
                    '%buybackId%' => $chat->id_ad_buyback
                ],
                'Modules.Adbuyback.Alert'
            ));
        }

        if (!$chat->toggleStatus()) {
            throw new CannotActiveBuyBackChatException($this->translator->trans(
                'Failed to toggle status of chat with id %chatId%.',
                ['%chatId%' => $chat->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
