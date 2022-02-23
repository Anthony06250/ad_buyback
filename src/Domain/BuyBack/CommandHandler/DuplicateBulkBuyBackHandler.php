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
use AdBuyBack\Domain\BuyBackImage\Command\DuplicateBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Query\GetImageForBuyBack;
use AdBuyBack\Model\BuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopException;

final class DuplicateBulkBuyBackHandler
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
     * @param DuplicateBulkBuyBackCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackCommand $command): void
    {
        $buybackIds = $command->getId()->getValue();

        try {
            $buybacks = $this->getBuyBack($buybackIds);

            $this->duplicateBuyBack($buybacks);
            $this->duplicateBuyBackImage($buybacks);
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
     * @param array $buybacks
     * @return void
     */
    private function duplicateBuyBack(array &$buybacks): void
    {
        foreach ($buybacks as $key => $buyback) {
            $buybacks[$key] = $buyback->duplicateObject();
            $buybacks[$key]->old_id = $buyback->id;

            if (!$buybacks[$key]->save()) {
                throw new CannotDuplicateBulkBuyBackException(sprintf('Failed to duplicate buy backs with id "%s"', $buyback->id));
            }
        }
    }

    /**
     * @param array $buybacks
     * @return void
     */
    private function duplicateBuyBackImage(array $buybacks): void
    {
        foreach ($buybacks as $buyback) {
            if ($images = $this->commandBus->handle(new GetImageForBuyBack($buyback->old_id))->getData()) {
                foreach ($images as $key => $image) {
                    $images[$key] = $image['id_ad_buyback_image'];
                }

                $this->commandBus->handle(new DuplicateBulkBuyBackImageCommand($images, (int)$buyback->id));
            }
        }
    }
}
