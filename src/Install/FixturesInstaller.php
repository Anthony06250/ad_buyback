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

namespace AdBuyBack\Install;

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Command\CreateBuyBackCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\CreateBuyBackMessageCommand;
use AdBuyBack\Tools\BuyBackTools;

final class FixturesInstaller
{
    /**
     * @return void
     */
    public function install(): void
    {
        // Use custom kernel for front office
        $commandBus = Ad_BuyBack::getService('prestashop.core.command_bus');
        $buybacks = [
            [
                'id_customer' => 3,
                'id_gender' => 1,
                'firstname' => 'Anthony',
                'lastname' => 'DURET',
                'email' => 'anthony.duret@outlook.fr',
                'message' => 'Je vous aime mes Amours de ma vie !',
                'active' => 1
            ],
            [
                'id_gender' => 1,
                'firstname' => 'Antoine',
                'lastname' => 'DURET',
                'email' => 'antoine.duret@outlook.fr',
                'message' => 'Je t\'aime Papa !',
                'active' => 1
            ],
            [
                'id_gender' => 2,
                'firstname' => 'Ludiwine',
                'lastname' => 'DURET',
                'email' => 'ludiwine.duret@gmail.com',
                'message' => 'Je t\'aime mon Amour !',
                'active' => 1
            ]
        ];
        $messages = [
            [
                'id_ad_buyback_chat' => 1,
                'id_employee' => 1,
                'message' => 'En encore plus chaque jour !',
                'active' => 1
            ],
            [
                'id_ad_buyback_chat' => 2,
                'id_employee' => 1,
                'message' => 'Mon aussi mon fils !',
                'active' => 1
            ],
            [
                'id_ad_buyback_chat' => 3,
                'id_employee' => 1,
                'message' => 'Moi aussi mon amour !',
                'active' => 1
            ]
        ];

        foreach ($buybacks as $buyback) {
            $commandBus->handle((new CreateBuyBackCommand())->fromArray($buyback));
        }

        foreach ($messages as $message) {
            $commandBus->handle((new CreateBuyBackMessageCommand())->fromArray($message));
        }
    }
}
