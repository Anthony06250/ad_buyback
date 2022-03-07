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

namespace AdBuyBack\Adapter;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Tools;

final class RequestAdapter
{
    /**
     * @return Request
     */
    public static function getBuyBackFrontRequest(): Request
    {
        $request = new Request([], [
            'buy_back' => [
                'id_ad_buyback' => '',
                'id_customer' => Tools::getValue('id_customer'),
                'id_gender' => Tools::getValue('id_gender'),
                'firstname' => Tools::getValue('firstname'),
                'lastname' => Tools::getValue('lastname'),
                'email' => Tools::getValue('email'),
                'message' => Tools::getValue('message'),
                'active' => '1',
                '_token' => Tools::getValue('_token')
            ]
        ], [], [], [
            'buy_back' => [
                'image' => RequestAdapter::getImageFrontRequest()
            ]
        ]);

        $request->setMethod('POST');

        return $request;
    }

    /**
     * @return array
     */
    private static function getImageFrontRequest(): array
    {
        $result = [];

        foreach ($_FILES['image']['name'] as $key => $name) {
            if (!empty($name)) {
                $result[] = new UploadedFile(
                    $_FILES['image']['tmp_name'][$key],
                    $name,
                    $_FILES['image']['type'][$key],
                    $_FILES['image']['size'][$key],
                    $_FILES['image']['error'][$key]);
            }
        }

        return $result;
    }

    public static function getMessageFrontRequest(): Request
    {
        $request = new Request([], [
            'buy_back_message' => [
                'id_ad_buyback_message' => '',
                'id_ad_buyback_chat' => Tools::getValue('id_ad_buyback_chat'),
                'id_customer' => Tools::getValue('id_customer'),
                'message' => Tools::getValue('message'),
                'active' => '1',
                '_token' => Tools::getValue('_token')
            ]]);

        $request->setMethod('POST');

        return $request;
    }
}
