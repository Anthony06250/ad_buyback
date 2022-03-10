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

namespace AdBuyBack\Model;

use Context;
use ObjectModel;
use PrestaShopCollection;
use PrestaShopException;

final class BuyBackChat extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ad_buyback;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var string
     */
    public $date_add;

    /**
     * @var string
     */
    public $date_upd;

    /**
     * @var string
     */
    public $token;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'ad_buyback_chat',
        'primary' => 'id_ad_buyback_chat',
        'fields' => [
            'id_ad_buyback' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false],
            'token' => ['type' => self::TYPE_STRING, 'validate' => 'isMd5', 'copy_post' => false]
        ],
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach (self::$definition['fields'] as $key => $value) {
            $result[$key] = $this->{$key};
        }

        return $result;
    }

    /**
     * @param array $data
     * @return BuyBackChat
     */
    public function fromArray(array $data): BuyBackChat
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getBuyBackChats(): array
    {
        $languageId = Context::getContext()->language->id;
        $collection = new PrestaShopCollection('AdBuyBack\Model\BuyBackChat', $languageId);

        return $collection->getResults();
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getBuyBackChatsList(): array
    {
        $result = [];

        foreach (self::getBuyBackChats() as $chat) {
            $result[$chat->id] = $chat->id;
        }

        arsort($result);

        return $result;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getBuyBacksList(): array
    {
        $result = [];

        foreach (self::getBuyBackChats() as $chat) {
            if (!in_array($chat->id_ad_buyback, $result)) {
                $result[$chat->id_ad_buyback] = $chat->id_ad_buyback;
            }
        }

        arsort($result);

        return $result;
    }
}
