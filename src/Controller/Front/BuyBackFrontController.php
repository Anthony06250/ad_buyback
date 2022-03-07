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

namespace AdBuyBack\Controller\Front;

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Query\GetBuyBackForFront;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForBuyBack;
use ModuleFrontController;
use PrestaShopException;

class BuyBackFrontController extends ModuleFrontController
{
    /**
     * @var bool
     */
    public $ssl = true;

    /**
     * @return void
     */
    public function setMedia()
    {
        parent::setMedia();
        $this->registerStylesheet(
            'module-' . $this->module->name . '-front-buyback',
            'modules/' . '/' . $this->module->name . '/views/css/front.buyback.css',
            ['media' => 'all', 'priority' => 150]
        );
        $this->registerStylesheet(
            'module-' . $this->module->name . '-front-chat',
            'modules/' . '/' . $this->module->name . '/views/css/front.chat.css',
            ['media' => 'all', 'priority' => 150]
        );
    }

    /**
     * @return void
     * @throws PrestaShopException
     */
    public function initContent(): void
    {
        parent::initContent();
        $this->indexAction();
    }

    /**
     * @return void
     * @throws PrestaShopException
     */
    private function indexAction(): void
    {
        // Use custom kernel for front office
        $buybacks = Ad_BuyBack::handle(new GetBuyBackForFront($this->context->customer->id))->getData();

        foreach ($buybacks as $key => $buyback) {
            $chats = Ad_BuyBack::handle(new GetChatForBuyBack($buyback['id_ad_buyback']))->getData();

            foreach ($chats as $chat) {
                $chat['messages'][] = Ad_BuyBack::handle(new GetMessageForBuyBack($chat['id_ad_buyback_chat']))->getData();
                $buybacks[$key]['chats'][] = $chat;
            }
        }

        $this->context->smarty->assign(['buybacks' => $buybacks]);
        $this->setTemplate('module:' . $this->module->name . '/views/templates/front/buyback.tpl');
    }
}
