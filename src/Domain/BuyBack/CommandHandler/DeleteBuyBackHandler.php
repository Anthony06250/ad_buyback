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

use AdBuyBack\Domain\BuyBackChat\Command\DeleteBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Domain\BuyBackImage\Command\DeleteBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDeleteBuyBackException;
use AdBuyBack\Domain\BuyBackImage\Query\GetImageForBuyBack;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DeleteBuyBackHandler
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
     * @param DeleteBuyBackCommand $command
     * @return void
     */
    public function handle(DeleteBuyBackCommand $command): void
    {
        $buybackId = $command->getId()->getValue();

        try {
            $buyback = new BuyBack($buybackId);

            $this->deleteBuyBack($buyback);
            $this->deleteBuyBackChat($buyback);
            $this->deleteBuyBackImage($buyback);
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBuyBackException($exception->getMessage());
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     * @throws PrestaShopException
     */
    private function deleteBuyBack(BuyBack $buyback): void
    {
        if (!$buyback->delete()) {
            throw new CannotDeleteBuyBackException($this->translator->trans(
                'Failed to delete buyback with id %buybackId%.',
                ['%buybackId%' => $buyback->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function deleteBuyBackChat(BuyBack $buyback): void
    {
        if ($chats = $this->commandBus->handle(new GetChatForBuyBack($buyback->id))->getData()) {
            foreach ($chats as $key => $chat) {
                $chats[$key] = $chat['id_ad_buyback_chat'];
            }

            $this->commandBus->handle(new DeleteBulkBuyBackChatCommand($chats));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function deleteBuyBackImage(BuyBack $buyback): void
    {
        if ($images = $this->commandBus->handle(new GetImageForBuyBack($buyback->id))->getData()) {
            foreach ($images as $key => $image) {
                $images[$key] = $image['id_ad_buyback_image'];
            }

            $this->commandBus->handle(new DeleteBulkBuyBackImageCommand($images));
        }
    }
}
