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

namespace AdBuyBack\Domain\BuyBack\QueryHandler;

use AdBuyBack\Domain\BuyBack\Query\GetBuyBackForFront;
use AdBuyBack\Domain\BuyBack\QueryResult\BuyBackForFront;

final class GetBuyBackForFrontHandler extends AbstractQueryHandler
{
    /**
     * @param GetBuyBackForFront $query
     * @return BuyBackForFront
     */
    public function handle(GetBuyBackForFront $query): BuyBackForFront
    {
        if (!$query->getId()) {
            return new BuyBackForFront(false);
        }

        return new BuyBackForFront($this->repository->findAllBy([
            'id_customer' => $query->getId()->getValue()
        ], [
            'date_upd' => 'DESC',
            'date_add' => 'DESC',
            'id_ad_buyback' => 'DESC'
        ],
        [
            'id_ad_buyback',
            'active',
            'date_add',
            'date_upd'
        ]));
    }
}
