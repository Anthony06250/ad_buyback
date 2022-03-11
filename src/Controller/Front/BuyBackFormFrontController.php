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
use ModuleFrontController;
use PrestaShopException;
use Symfony\Component\HttpFoundation\Request;
use Tools;

class BuyBackFormFrontController extends ModuleFrontController
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
            'module-' . $this->module->name . '-front-form',
            'modules/' . '/' . $this->module->name . '/views/css/front.form.css',
            ['media' => 'all', 'priority' => 150]
        );
        $this->registerJavascript(
            'module-' . $this->module->name . '-front-form',
            'modules/' . $this->module->name . '/views/js/buyback.front.form.bundle.js',
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
        $this->indexAction();
    }

    /**
     * @return void
     * @throws PrestaShopException
     */
    private function indexAction(): void
    {
        // Use custom kernel for front office
        $form = Ad_BuyBack::getService('adbuyback.form.form_builder.buyback')->getForm();

        $this->context->smarty->assign(['form' => SmartyAdapter::convertTwigFormToSmarty($form)]);
        $this->setTemplate('module:' . $this->module->name . '/views/templates/front/form.tpl');
    }

    /**
     * @return void
     */
    public function postProcess(): void
    {
        if (Tools::isSubmit('ad-buyback-front-form')) {
            $this->createAction(RequestAdapter::getBuyBackFrontRequest());
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    private function createAction(Request $request): void
    {
        $form = Ad_BuyBack::getService('adbuyback.form.form_builder.buyback')->getForm();
        $formHandler = Ad_BuyBack::getService('adbuyback.form.form_handler.buyback');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->success[] = $this->trans('The buyback form has been successfully send.', [], 'Modules.Adbuyback.Alert');
                // => TODO: Send mail here for buyback creation success

                $this->redirectWithNotifications('/');
            }

            $this->errors[] = $this->trans('Ho !!! Unknown ERROR !!!', [], 'Modules.Adbuyback.Alert');
        } catch (BuyBackException $exception) {
            $this->errors[] = $exception->getMessage();
        }

        $this->redirectWithNotifications($this->getCurrentURL());
    }

    /**
     * @return array
     */
    public function getBreadcrumbLinks(): array
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        if ($this->context->customer->id) {
            $breadcrumb['links'][] = $this->addMyAccountToBreadcrumb();
            $breadcrumb['links'][] = [
                'title' => $this->trans('Buyback', [], 'Modules.Adbuyback.Front'),
                'url' => $this->context->link->getModuleLink('ad_buyback', 'buyback')
            ];
        }

        $breadcrumb['links'][] = [
            'title' => $this->trans('Buyback form', [], 'Modules.Adbuyback.Front'),
            'url' => $this->context->link->getModuleLink('ad_buyback', 'form')
        ];

        return $breadcrumb;
    }
}
