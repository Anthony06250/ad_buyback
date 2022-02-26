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

use AdBuyBack\Model\BuyBack;
use DateTime;
use PrestaShopDatabaseException;
use PrestaShopException;

class FixturesInstaller
{
    /**
     * @return void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function install(): void
    {
        $datas = [
            [
                'id_gender' => 1,
                'firstname' => 'Anthony',
                'lastname' => 'DURET',
                'email' => 'anthony.duret@outlook.fr',
                'description' => 'Je vous aime mes Amours de ma vie !',
                'active' => 1
            ],
            [
                'id_gender' => 1,
                'firstname' => 'Antoine',
                'lastname' => 'DURET',
                'email' => 'antoine.duret@outlook.fr',
                'description' => 'Je t\'aime Papa !',
                'active' => 1
            ],
            [
                'id_gender' => 2,
                'firstname' => 'Ludiwine',
                'lastname' => 'DURET',
                'email' => 'ludiwine.duret@gmail.com',
                'description' => 'Je t\'aime mon Amour !',
                'active' => 1
            ]
        ];

        foreach ($datas as $data) {
            (new BuyBack())->fromArray($data)->save();
        }
    }
}
