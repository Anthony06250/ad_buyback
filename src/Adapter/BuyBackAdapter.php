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

final class BuyBackAdapter
{
    /**
     * @return Request
     */
    public static function getFrontRequest(): Request
    {
        $request = new Request([], [
            'buy_back' => [
                'firstname' => Tools::getValue('firstname'),
                'lastname' => Tools::getValue('lastname'),
                'email' => Tools::getValue('email'),
                'description' => Tools::getValue('description'),
                'active' => true,
                'image' => BuyBackAdapter::getImageRequest(),
                '_token' => Tools::getValue('_token')
            ]]);

        $request->setMethod('POST');

        return $request;
    }

    /**
     * @return array
     */
    private static function getImageRequest(): array
    {
        $result = [];

        foreach ($_FILES['image']['name'] as $key => $name) {
            $path = $_FILES['image']['tmp_name'][$key];
            $type = $_FILES['image']['type'][$key];
            $size = $_FILES['image']['size'][$key];
            $error = $_FILES['image']['error'][$key];
            $result[] = new UploadedFile($path, $name, $type, $size, $error);
        }

        return $result;
    }
}
