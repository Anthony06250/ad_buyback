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

namespace AdBuyBack\Domain\BuyBackMessage\QueryHandler;

use AdBuyBack\Domain\BuyBack\QueryHandler\AbstractQueryHandler;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForBuyBack;
use AdBuyBack\Domain\BuyBackMessage\QueryResult\MessageForBuyBack;

final class GetMessageForBuyBackHandler extends AbstractQueryHandler
{
    /**
     * @param GetMessageForBuyBack $query
     * @return MessageForBuyBack
     */
    public function handle(GetMessageForBuyBack $query): MessageForBuyBack
    {
        if (!$query->getId()) {
            return new MessageForBuyBack(false);
        }

        return new MessageForBuyBack($this->repository->findBy([
            'id_ad_buyback_chat' => $query->getId()->getValue(),
            'active' => true
        ], [
            'date_add' => 'DESC',
            'date_upd' => 'DESC',
            'id_ad_buyback_message' => 'DESC'
        ]));
    }
}
