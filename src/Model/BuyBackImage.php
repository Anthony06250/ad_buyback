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
use DateTime;
use ObjectModel;
use PrestaShopCollection;
use PrestaShopException;

final class BuyBackImage extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ad_buyback;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $date_add;

    /**
     * @param $id
     * @param $id_lang
     * @param $id_shop
     * @throws PrestaShopException
     */
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        $this->date_add = (new DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'ad_buyback_image',
        'primary' => 'id_ad_buyback_image',
        'fields' => [
            'id_ad_buyback' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'name' => ['type' => self::TYPE_STRING, 'size' => 128],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false]
        ],
    ];

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];

        foreach (BuyBack::$definition['fields'] as $key => $value) {
            $result[$key] = $this->{$key};
        }

        return $result;
    }

    /**
     * @param array $data
     * @return BuyBackImage
     */
    public function fromArray(array $data): BuyBackImage
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
    public static function getBuyBackList(): array
    {
        $idLang = Context::getContext()->language->id;
        $result = [];

        foreach ((new PrestaShopCollection('AdBuyBack\Model\BuyBackImage', $idLang))->getResults() as $image) {
            if (!in_array($image->id_ad_buyback, $result)) {
                $result[$image->id_ad_buyback] = $image->id_ad_buyback;
            }
        }

        asort($result);

        return $result;
    }
}
