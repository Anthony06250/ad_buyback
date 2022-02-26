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

use DateTime;
use ObjectModel;
use PrestaShopException;

final class BuyBack extends ObjectModel
{
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
     * @var string
     */
    public $description;

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
     * @param $id
     * @param $id_lang
     * @param $id_shop
     * @throws PrestaShopException
     */
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        $this->date_add = (new DateTime())->format('Y-m-d H:i:s');
        $this->date_upd = (new DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'ad_buyback',
        'primary' => 'id_ad_buyback',
        'fields' => [
            'id_gender' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
            'firstname' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 255],
            'lastname' => ['type' => self::TYPE_STRING, 'validate' => 'isName', 'size' => 255],
            'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'size' => 255],
            'description' => ['type' => self::TYPE_HTML, 'validate' => 'isCleanHtml', 'size' => 65000, 'copy_post' => false],
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

        foreach (BuyBack::$definition['fields'] as $key => $value) {
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
     * @param array $ids
     * @return bool
     * @throws PrestaShopException
     */
    public function duplicateSelection(array $ids): bool
    {
        $result = true;

        foreach ($ids as $id) {
            $this->id = (int)$id;

            $result = $result && $this->duplicateObject()->save();
        }

        return $result;
    }

    /**
     * @param array $ids
     * @param string $field
     * @param bool $status
     * @return bool
     * @throws PrestaShopException
     */
    public function toggleSelection(array $ids, string $field, bool $status = null): bool
    {
        $result = true;

        foreach ($ids as $id) {
            $object = new BuyBack($id);

            $object->setFieldsToUpdate([$field => true]);
            $object->{$field} = $status ?? !(int)$this->{$field};

            $result = $result && $object->update(false);
        }

        return $result;
    }
}
