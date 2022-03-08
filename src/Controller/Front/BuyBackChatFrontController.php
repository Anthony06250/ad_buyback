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
use AdBuyBack\Adapter\RequestAdapter;
use AdBuyBack\Adapter\SmartyAdapter;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForForm;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForChat;
use ModuleFrontController;
use PrestaShopException;
use Symfony\Component\HttpFoundation\Request;
use Tools;

class BuyBackChatFrontController extends ModuleFrontController
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
            'module-' . $this->module->name . '-front-chat',
            'modules/' . '/' . $this->module->name . '/views/css/front.chat.css',
            ['media' => 'all', 'priority' => 150]
        );
        $this->registerJavascript(
            'module-' . $this->module->name . '-front-chat',
            'modules/' . $this->module->name . '/views/js/buyback_chat.front.chat.bundle.js',
            ['priority' => 200, 'attribute' => 'async']
        );
    }

    /**
     * @return void
     * @throws PrestaShopException
     */
    public function initContent(): void
    {
        parent::initContent();
        $this->indexAction((int)Tools::getValue('chatId'));
    }

    /**
     * @param int $chatId
     * @return void
     * @throws PrestaShopException
     */
    private function indexAction(int $chatId): void
    {
        // Use custom kernel for front office
        if ($chat = Ad_BuyBack::handle(new GetChatForForm($chatId))->getData()) {
            $chat['messages'] = Ad_BuyBack::handle(new GetMessageForChat($chatId))->getData();
            $this->context->smarty->assign(['chat' => $chat]);
        }

        $form = Ad_BuyBack::getService('adbuyback.form.form_builder.buyback_message')->getForm();

        $this->context->smarty->assign(['form' => SmartyAdapter::convertTwigFormToSmarty($form)]);
        $this->setTemplate('module:' . $this->module->name . '/views/templates/front/chat.tpl');
    }

    /**
     * @return void
     */
    public function postProcess(): void
    {
        if (Tools::isSubmit('ad-buyback-front-message-form')) {
            $this->createAction(RequestAdapter::getMessageFrontRequest());
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    private function createAction(Request $request): void
    {
        $form = Ad_BuyBack::getService('adbuyback.form.form_builder.buyback_message')->getForm();
        $formHandler = Ad_BuyBack::getService('adbuyback.form.form_handler.buyback_message');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->success[] = $this->trans('The message has been successfully send.', [], 'Modules.Adbuyback.Alert');
            }
            else {
                $this->errors[] = $this->trans('Ho !!! Unknown ERROR !!!', [], 'Modules.Adbuyback.Alert');
            }
        } catch (BuyBackException $exception) {
            $this->errors[] = $this->trans($exception->getMessage(), [], 'Modules.Adbuyback.Alert');
        }

        $this->redirectWithNotifications($this->getCurrentURL());
    }

    /**
     * @return array
     */
    public function getBreadcrumbLinks(): array
    {
        $breadcrumb = parent::getBreadcrumbLinks();
        $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
        $breadcrumb['links'][] = [
            'title' => $this->trans('Buyback', [], 'Modules.Adbuyback.Front'),
            'url' => $this->context->link->getModuleLink('ad_buyback', 'buyback')
        ];
        $breadcrumb['links'][] = [
            'title' => $this->trans('Chat', [], 'Modules.Adbuyback.Front'),
            'url' => $this->context->link->getModuleLink('ad_buyback', 'chat')
        ];

        return $breadcrumb;
    }
}
