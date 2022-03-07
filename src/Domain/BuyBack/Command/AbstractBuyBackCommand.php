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

namespace AdBuyBack\Domain\BuyBack\Command;

use AdBuyBack\Domain\BuyBack\ValueObject\BuyBackId;

class AbstractBuyBackCommand
{
    /**
     * @var BuyBackId
     */
    private $id;

    /**
     * @param mixed $id
     */
    public function __construct($id = null)
    {
        $this->id = new BuyBackId($id);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_slice(get_object_vars($this), 0, -1);
    }

    /**
     * @param array $data
     * @return AbstractBuyBackCommand
     */
    public function fromArray(array $data): AbstractBuyBackCommand
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                dump($key);
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * @return BuyBackId
     */
    public function getId(): BuyBackId
    {
        return $this->id;
    }
}
