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

class BuyBackFrontController extends ModuleFrontController
{
    /**
     * Use front kernel to get service - Ad_BuyBack::getService('service')
     */

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
        $this->registerJavascript(
            'module-' . $this->module->name . '-form',
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
        $form = Ad_BuyBack::getService('adbuyback.form.form_builder.buyback')->getForm();

        $this->context->smarty->assign(['form' => SmartyAdapter::convertTwigFormToSmarty($form)]);
        $this->setTemplate('module:' . $this->module->name . '/views/templates/front/form.tpl');
    }

    /**
     * @return void
     */
    public function postProcess(): void
    {
        if (Tools::getIsset('firstname')) {
            $this->createAction(RequestAdapter::getFrontRequest());
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
            if ($formHandler->handle($form)->getIdentifiableObjectId() !== null) {
                $this->success[] = $this->trans('The buy back has been successfully created.', [], 'Modules.Adbuyback.Alert');

                $this->redirectWithNotifications('/');
            }

            $this->errors[] = $this->trans('Ho shit ! ERROR !!!', [], 'Modules.Adbuyback.Alert');
        } catch (BuyBackException $exception) {
            $this->errors[] = $this->trans($exception->getMessage(), [], 'Modules.Adbuyback.Alert');
        }

        $this->redirectWithNotifications($this->getCurrentURL());
    }
}
