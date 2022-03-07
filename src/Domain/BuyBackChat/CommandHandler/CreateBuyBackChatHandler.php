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

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Query\GetIsActiveBuyBack;
use AdBuyBack\Domain\BuyBackChat\Command\CreateBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Exception\CannotCreateBuyBackChatException;
use AdBuyBack\Domain\BuyBackChat\ValueObject\BuyBackChatId;
use AdBuyBack\Model\BuyBackChat;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class CreateBuyBackChatHandler
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
     *
     */
    public function __construct()
    {
        // Use custom kernel for front office
        $this->commandBus = Ad_BuyBack::getService('prestashop.core.command_bus');
        $this->translator = Ad_BuyBack::getService('translator');
    }

    /**
     * @param CreateBuyBackChatCommand $command
     * @return BuyBackChatId
     */
    public function handle(CreateBuyBackChatCommand $command): BuyBackChatId
    {
        try {
            $chat = new BuyBackChat();

            $this->createBuyBackChat($chat, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackChatException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$chat->id);
    }

    /**
     * @param BuyBackChat $chat
     * @param CreateBuyBackChatCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function createBuyBackChat(BuyBackChat $chat, CreateBuyBackChatCommand $command): void
    {
        $buybackId = $command->getBuyBackId();

        if (!$this->commandBus->handle(new GetIsActiveBuyBack($buybackId))) {
            $command->setActive(false);
        }

        $chat->hydrate($command->toArray());

        if (!$chat->add()) {
            throw new CannotCreateBuyBackChatException($this->translator->trans(
                'Failed to create buyback chat.',
                [],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
