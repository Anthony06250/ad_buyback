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
use Employee;
use ObjectModel;
use PrestaShopCollection;
use PrestaShopException;

final class BuyBackMessage extends ObjectModel
{
    /**
     * @var int
     */
    public $id_ad_buyback_chat;

    /**
     * @var int
     */
    public $id_customer;

    /**
     * @var int
     */
    public $id_employee;

    /**
     * @var string
     */
    public $message;

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
        'table' => 'ad_buyback_message',
        'primary' => 'id_ad_buyback_message',
        'fields' => [
            'id_ad_buyback_chat' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'id_employee' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'message' => ['type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 65000, 'copy_post' => false],
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
     * @return BuyBackMessage
     */
    public function fromArray(array $data): BuyBackMessage
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
    public static function getBuyBackMessages(): array
    {
        $languageId = Context::getContext()->language->id;
        $collection = new PrestaShopCollection('AdBuyBack\Model\BuyBackMessage', $languageId);

        return $collection->getResults();
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getChatsList(): array
    {
        $result = [];

        foreach (self::getBuyBackMessages() as $message) {
            if (!in_array($message->id_ad_buyback_chat, $result)) {
                $result[$message->id_ad_buyback_chat] = $message->id_ad_buyback_chat;
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
        $result = [];

        foreach (self::getBuyBackMessages() as $message) {
            if (!in_array($message->id_customer, $result)) {
                $result[$message->id_customer] = $message->id_customer;
            }
        }

        asort($result);

        return $result;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getEmployeesList(): array
    {
        $result = [];

        foreach (self::getBuyBackMessages() as $message) {
            if (!in_array($message->id_employee, $result)) {
                $result[$message->id_employee] = $message->id_employee;
            }
        }

        asort($result);

        return $result;
    }

    /**
     * @return array
     * @throws PrestaShopException
     */
    public static function getSendersList(): array
    {
        $customersList = self::getCustomersList();
        $employeesList = self::getEmployeesList();
        $genders = BuyBack::getGendersList();
        $result = [];

        foreach (BuyBack::getBuyBacks() as $buyback) {
            if (in_array($buyback->id_customer, $customersList)) {
                foreach ($genders as $genderName => $genderId) {
                    if ($genderId === $buyback->id_gender) {
                        $fullname = $genderName . ' ' . $buyback->firstname . ' ' . $buyback->lastname;
                        $result['customer_' . $fullname] = $fullname;
                    }
                }
            }
        }

        foreach (Employee::getEmployees() as $employee) {
            if (in_array($employee['id_employee'], $employeesList)) {
                $fullname = $employee['firstname'] . ' ' . $employee['lastname'];
                $result['employee_' . $fullname] = $fullname;
            }
        }

        asort($result);

        return array_flip($result);
    }
}
