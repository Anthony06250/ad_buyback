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

final class BuyBackRepository
{
    /**
     * @var Connection the Database connection.
     */
    private $connection;

    /**
     * @var string the Database name.
     */
    private $databaseName;

    /**
     * @param Connection|Object $connection
     * @param string $databasePrefix
     */
    public function __construct(Connection $connection, string $databasePrefix = 'ps_')
    {
        $this->connection = $connection;
        $this->databaseName = $databasePrefix . 'ad_buyback';
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

        $query->from($this->databaseName);

        foreach ($fields as $field) {
            $query->addSelect($field);
        }

        foreach ($params as $key => $param) {
            $query->andWhere("`$key` = :$key")
                ->setParameter($key, $param);
        }

        foreach ($orders as $key => $order) {
            $query->addOrderBy("`$key`", $order);
        }

        return $query;
    }
}
