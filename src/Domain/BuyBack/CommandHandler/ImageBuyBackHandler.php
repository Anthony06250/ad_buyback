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

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Command\CreateBuyBackCommand;
use AdBuyBack\Domain\BuyBackImage\Command\CreateBuyBackImageCommand;
use AdBuyBack\Model\BuyBack;

class ImageBuyBackHandler
{
    /**
     * @param BuyBack $buyback
     * @param CreateBuyBackCommand $command
     * @return void
     */
    protected function createBuyBackImage(BuyBack $buyback, CreateBuyBackCommand $command): void
    {
        if ($images = $command->getImage()) {
            // Use custom kernel for front office
            $commandBus = Ad_BuyBack::getService('prestashop.core.command_bus');

            foreach ($images as $image) {
                $commandBus->handle((new CreateBuyBackImageCommand())->fromArray([
                    'id_ad_buyback' => $buyback->id,
                    'image' => $image
                ]));
            }
        }
    }
}
