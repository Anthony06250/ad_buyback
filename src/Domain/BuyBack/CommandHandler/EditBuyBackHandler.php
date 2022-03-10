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

use AdBuyBack\Domain\BuyBack\Command\EditBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotEditBuyBackException;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class EditBuyBackHandler extends ImageBuyBackHandler
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
     * @param EditBuyBackCommand $command
     * @return void
     */
    public function handle(EditBuyBackCommand $command): void
    {
        $buybackId = $command->getId()->getValue();

        try {
            $buyback = new BuyBack($buybackId);

            $this->editBuyBack($buyback, $command);
            $this->createBuyBackImage($buyback, $command);
            $this->editBuyBackChat($buyback);
        } catch (PrestaShopException $exception) {
            throw new CannotEditBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param BuyBack $buyback
     * @param EditBuyBackCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function editBuyBack(BuyBack $buyback, EditBuyBackCommand $command): void
    {
        $buyback->hydrate($command->toArray());

        if (!$buyback->update()) {
            throw new CannotEditBuyBackException($this->translator->trans(
                'Failed to update buyback with id %buybackId%.',
                ['%buybackId%' => $buyback->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function editBuyBackChat(BuyBack $buyback): void
    {
        if (!$buyback->active && $chats = $this->commandBus->handle(new GetChatForBuyBack($buyback->id))->getData()) {
            foreach ($chats as $key => $chat) {
                $chats[$key] = $chat['id_ad_buyback_chat'];
            }

            $this->commandBus->handle(new ActiveBulkBuyBackChatCommand($chats, false, false));
        }
    }
}
