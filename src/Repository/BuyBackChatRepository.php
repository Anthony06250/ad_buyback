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

final class BuyBackChatRepository
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
     * @var int the Language id.
     */
    private $languageId;

    /**
     * @param Connection|Object $connection
     * @param string $databasePrefix
     * @param int $languageId
     */
    public function __construct(Connection $connection, string $databasePrefix, int $languageId)
    {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->databaseName = $databasePrefix . 'ad_buyback_chat';
        $this->languageId = $languageId;
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

    /**
     * @param $chatId
     * @return mixed
     */
    public function getCustomerForMessage($chatId)
    {
        $query = $this->connection->createQueryBuilder()
            ->from($this->databaseName, 'p')
            ->leftJoin('p',
                $this->databasePrefix . 'ad_buyback',
                'pb',
                'pb.`id_ad_buyback` = p.`id_ad_buyback`'
            )
            ->leftJoin('pb',
                $this->databasePrefix . 'gender_lang',
                'pbg',
                'pbg.`id_gender` = pb.`id_gender` AND pbg.`id_lang` = :id_lang'
            )
            ->leftJoin('pb',
                $this->databasePrefix . 'customer',
                'pc',
                'pb.`id_customer` > 0 AND pc.`id_customer` = pb.`id_customer`'
            )
            ->leftJoin('pc',
                $this->databasePrefix . 'gender_lang',
                'pcg',
                'pb.`id_customer` > 0 AND pcg.`id_gender` = pc.`id_gender`'
            )
            ->setParameter('id_lang', $this->languageId)
            ->where('p.`id_ad_buyback_chat` = :chatId')
            ->setParameter('chatId', $chatId)
            ->select('pb.`id_customer`')
            ->addSelect('(CASE WHEN pb.`id_customer` > 0
                    THEN CONCAT(pcg.`name`, " ", pc.`firstname`, " ", pc.`lastname`)
                    ELSE CONCAT(pbg.`name`, " ", pb.`firstname`, " ", pb.`lastname`)
                    END) AS `fullname`'
            );

        return $query->execute()->fetch();
    }
}
