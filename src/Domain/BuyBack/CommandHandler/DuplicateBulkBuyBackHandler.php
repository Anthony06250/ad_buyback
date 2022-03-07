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

use AdBuyBack\Domain\BuyBack\Command\DuplicateBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotDuplicateBulkBuyBackException;
use AdBuyBack\Domain\BuyBackChat\Command\DuplicateBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Domain\BuyBackImage\Command\DuplicateBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Query\GetImageForBuyBack;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DuplicateBulkBuyBackHandler
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
     * @param DuplicateBulkBuyBackCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackCommand $command): void
    {
        $buybackIds = $command->getId()->getValue();

        try {
            foreach ($this->getBuyBack($buybackIds) as $buyback) {
                $this->duplicateBuyBack($buyback);
                $this->duplicateBuyBackChat($buyback);
                $this->duplicateBuyBackImage($buyback);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDuplicateBulkBuyBackException($exception->getMessage());
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
     * @param BuyBack $buyback
     * @return void
     * @throws PrestaShopException
     */
    private function duplicateBuyBack(BuyBack &$buyback): void
    {
        $oldId = $buyback->id;
        $buyback = $buyback->duplicateObject();
        $buyback->oldId = $oldId;

        if (!$buyback->save()) {
            throw new CannotDuplicateBulkBuyBackException($this->translator->trans(
                'Failed to duplicate buyback with id %buybackId%.',
                ['%buybackId%' => $oldId],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function duplicateBuyBackChat(BuyBack $buyback): void
    {
        if ($chats = $this->commandBus->handle(new GetChatForBuyBack($buyback->oldId ?? $buyback->id))->getData()) {
            foreach ($chats as $key => $chat) {
                $chats[$key] = $chat['id_ad_buyback_chat'];
            }

            $this->commandBus->handle(new DuplicateBulkBuyBackChatCommand($chats, (int)$buyback->id));
        }
    }

    /**
     * @param BuyBack $buyback
     * @return void
     */
    private function duplicateBuyBackImage(BuyBack $buyback): void
    {
        if ($images = $this->commandBus->handle(new GetImageForBuyBack($buyback->oldId ?? $buyback->id))->getData()) {
            foreach ($images as $key => $image) {
                $images[$key] = $image['id_ad_buyback_image'];
            }

            $this->commandBus->handle(new DuplicateBulkBuyBackImageCommand($images, (int)$buyback->id));
        }
    }
}
