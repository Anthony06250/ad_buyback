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

use AdBuyBack\Domain\BuyBack\Command\ActiveBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotActiveBuyBackException;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class ActiveBuyBackHandler
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
     * @param ActiveBuyBackCommand $command
     * @return void
     */
    public function handle(ActiveBuyBackCommand $command): void
    {
        $buybackId = $command->getId()->getValue();

        try {
            $buyback = new BuyBack($buybackId);

            $this->activeBuyBack($buyback);
            $this->activeBuyBackChat($buyback);
        } catch (PrestaShopException $exception) {
            throw new CannotActiveBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param BuyBack $buyBack
     * @return void
     * @throws PrestaShopException
     */
    public function activeBuyBack(BuyBack $buyBack): void
    {
        if (!$buyBack->toggleStatus()) {
            throw new CannotActiveBuyBackException($this->translator->trans(
                'Failed to toggle status of buyback with id %buybackId%.',
                ['%buybackId%' => $buyBack->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function activeBuyBackChat(BuyBack $buyback): void
    {
        if (!$buyback->active && $chats = $this->commandBus->handle(new GetChatForBuyBack($buyback->id))->getData()) {
            foreach ($chats as $key => $chat) {
                $chats[$key] = $chat['id_ad_buyback_chat'];
            }

            $this->commandBus->handle(new ActiveBulkBuyBackChatCommand($chats, false, false));
        }
    }
}
