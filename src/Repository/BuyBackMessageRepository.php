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

namespace AdBuyBack\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

final class BuyBackMessageRepository
{
    /**
     * @var Connection the Database connection.
     */
    private $connection;

    /**
     * @var string the Database prefix.
     */
    private $databasePrefix;

    /**
     * @var string the Database name.
     */
    private $databaseName;

    /**
     * @var int
     */
    private $contextLanguageId;

    /**
     * @param Connection|Object $connection
     * @param string $databasePrefix
     * @param int $contextLanguageId
     */
    public function __construct(Connection $connection, string $databasePrefix, int $contextLanguageId)
    {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->databaseName = $databasePrefix . 'ad_buyback_message';
        $this->contextLanguageId = $contextLanguageId;
    }

    /**
     * @param array $params
     * @param array $orders
     * @param array $fields
     * @return mixed
     */
    public function findBy(array $params, array $orders = [], array $fields = ['*'])
    {
        return $this->getQuery($params, $orders, $fields)->execute()->fetch();
    }

    /**
     * @param array $params
     * @param array $orders
     * @param array $fields
     * @return mixed[]
     */
    public function findAllBy(array $params, array $orders = [], array $fields = ['*'])
    {
        return $this->getQuery($params, $orders, $fields)->execute()->fetchAll();
    }

    /**
     * @param array $params
     * @param array $orders
     * @param array $fields
     * @return QueryBuilder
     */
    private function getQuery(array $params, array $orders, array $fields): QueryBuilder
    {
        $query = $this->connection->createQueryBuilder();

        $query->from($this->databaseName, 'p');

        foreach ($fields as $field) {
            $query->addSelect("p.$field");
        }

        $query->addSelect('CONCAT(pcg.`name`, " ", pc.`firstname`, " ", pc.`lastname`) AS `customer_name`')
            ->addSelect('CONCAT(pe.`firstname`, " ", pe.`lastname`) AS `employee_name`')
            ->addSelect('CONCAT(pbg.`name`, " ", pb.`firstname`, " ", pb.`lastname`) AS `default_name`')
            ->leftJoin('p',
                $this->databasePrefix . 'customer',
                'pc',
                'p.`id_customer` > 0 AND pc.`id_customer` = p.`id_customer`'
            )
            ->leftJoin('pc',
                $this->databasePrefix . 'gender_lang',
                'pcg',
                'pcg.`id_gender` = pc.`id_gender` AND pcg.`id_lang` = :id_lang'
            )
            ->leftJoin('p',
                $this->databasePrefix . 'employee',
                'pe',
                'p.`id_employee` > 0 AND pe.`id_employee` = p.`id_employee`'
            )
            ->leftJoin('p',
                $this->databasePrefix . 'ad_buyback_chat',
                'pch',
                'pch.`id_ad_buyback_chat` = p.`id_ad_buyback_chat`'
            )
            ->leftJoin('pch',
                $this->databasePrefix . 'ad_buyback',
                'pb',
                'pb.`id_ad_buyback` = pch.`id_ad_buyback`'
            )
            ->leftJoin('pb',
                $this->databasePrefix . 'gender_lang',
                'pbg',
                'pbg.`id_gender` = pb.`id_gender` AND pbg.`id_lang` = :id_lang'
            )
            ->setParameter('id_lang', $this->contextLanguageId);

        foreach ($params as $key => $param) {
            $query->andWhere("p.`$key` = :$key")
                ->setParameter($key, $param);
        }

        foreach ($orders as $key => $order) {
            $query->addOrderBy("p.`$key`", $order);
        }

        return $query;
    }
}
