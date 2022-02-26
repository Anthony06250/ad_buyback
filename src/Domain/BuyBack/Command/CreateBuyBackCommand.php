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

use DateTime;

class CreateBuyBackCommand extends AbstractBuyBackCommand
{
    /**
     * @var int
     */
    private $id_gender;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $image;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var DateTime
     */
    private $date_add;

    /**
     * @var DateTime
     */
    private $date_upd;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id_gender' => $this->id_gender,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'description' => $this->description,
            'image' => $this->image,
            'active' => $this->active,
            'date_add' => $this->date_add,
            'date_upd' => $this->date_upd
        ];
    }

    /**
     * @param array $data
     * @return CreateBuyBackCommand
     */
    public function fromArray(array $data): CreateBuyBackCommand
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
     */
    public function getImage(): array
    {
        return $this->image;
    }
}
