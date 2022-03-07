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
use Gender;
use ObjectModel;
use PrestaShopCollection;
use PrestaShopException;

final class BuyBack extends ObjectModel
{
    /**
     * @var int
     */
    public $id_customer;

    /**
     * @var int
     */
    public $id_gender;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $email;

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
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'ad_buyback',
        'primary' => 'id_ad_buyback',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'id_gender' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'firstname' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 255],
            'lastname' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 255],
            'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'size' => 255],
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'copy_post' => false]
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
     * @return BuyBack
     */
    public function fromArray(array $data): BuyBack
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
    public static function getBuyBacks(): array
    {
        $languageId = Context::getContext()->language->id;
        $collection = new PrestaShopCollection('AdBuyBack\Model\BuyBack', $languageId);

        return $collection->getResults();
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getBuyBacksList(): array
    {
        $result = [];

        foreach (self::getBuyBacks() as $buyback) {
            $result[$buyback->id] = $buyback->id;
        }

        return $result;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getGendersList(): array
    {
        $buybacks = self::getBuyBacks();
        $genders = Gender::getGenders()->getResults();
        $result = [];

        foreach ($buybacks as $buyback) {
            if (!in_array($buyback->id_gender, $result)) {
                foreach ($genders as $gender) {
                    if ($gender->id_gender === $buyback->id_gender) {
                        $result[$gender->name] = $buyback->id_gender;
                    }
                }
            }
        }

        asort($result);

        return $result;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getCustomersList(): array
    {
        $buybacks = self::getBuyBacks();
        $genders = self::getGendersList();
        $customersList = $result = [];

        foreach ($buybacks as $buyback) {
            if (!in_array($buyback->id_customer, $result)) {
                $customersList[] = $buyback->id_customer;
            }
            if (in_array($buyback->id_customer, $customersList)) {
                foreach ($genders as $genderName => $genderId) {
                    if (!array_key_exists($genderName . ' ' . $buyback->firstname . ' ' . $buyback->lastname, $result)
                        && $genderId === $buyback->id_gender) {
                        $fullname = $genderName . ' ' . $buyback->firstname . ' ' . $buyback->lastname;
                        $result[$fullname] = $fullname;
                    }
                }
            }
        }

        asort($result);

        return $result;
    }
}
