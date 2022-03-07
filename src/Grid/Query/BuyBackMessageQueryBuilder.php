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

namespace AdBuyBack\Grid\Query;

use Context;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

final class BuyBackMessageQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * -> TODO: Bug with sender filter, because customer LIKE is ambiguous and give one employee
     */

    /**
     * @var int
     */
    private $languageId;

    /**
     * @var int
     */
    private $shopId;

    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @param Connection $connection
     * @param string $databasePrefix
     * @param int $languageId
     * @param int $shopId
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     */
    public function __construct(Connection $connection, string $databasePrefix, int $languageId, int $shopId, DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator)
    {
        parent::__construct($connection, $databasePrefix);
        $this->languageId = $languageId;
        $this->shopId = $shopId;
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->getQueryBuilder($searchCriteria->getFilters());

        $query->select('p.`id_ad_buyback_message` AS `id`, p.`id_ad_buyback_chat`, p.`id_customer`, p.`id_employee`, p.`message`, p.`active`, p.`date_add`, p.`date_upd`')
            ->addSelect('(CASE WHEN p.`id_employee` > 0
                THEN CONCAT(pe.`firstname`, " ", pe.`lastname`)
                ELSE CONCAT(pbg.`name`, " ", pb.`firstname`, " ", pb.`lastname`)
                END) AS `sender`'
            );

        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $query)
            ->applySorting($searchCriteria, $query);

        return $query;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->getQueryBuilder($searchCriteria->getFilters());
        $query->select('COUNT(p.`id_ad_buyback_message`)');

        return $query;
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filters): QueryBuilder
    {
        $query = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . 'ad_buyback_message', 'p')
            ->leftJoin('p',
            $this->dbPrefix . 'ad_buyback_chat',
            'pc',
            'pc.`id_ad_buyback_chat` = p.`id_ad_buyback_chat`'
            )
            ->leftJoin('pc',
            $this->dbPrefix . 'ad_buyback',
            'pb',
            'pb.`id_ad_buyback` = pc.`id_ad_buyback`'
            )
            ->leftJoin('pb',
            $this->dbPrefix . 'gender_lang',
            'pbg',
            'pbg.`id_gender` = pb.`id_gender` AND pbg.`id_lang` = :id_lang'
            )
            ->leftJoin('p',
            $this->dbPrefix . 'employee',
            'pe',
            'p.`id_employee` > 0 AND pe.`id_employee` = p.`id_employee` AND pe.`id_lang` = :id_lang'
            )
            ->setParameter('id_lang', $this->languageId);

        foreach ($filters as $filterName => $filter) {
            if ('id_ad_buyback_chat' === $filterName) {
                $query->andWhere('p.`id_ad_buyback_chat` LIKE :id_ad_buyback_chat');
                $query->setParameter('id_ad_buyback_chat', '%' . $filter . '%');

                continue;
            }

            if ('sender' === $filterName) {
                $filter = explode('_', $filter);

                $query->andWhere('(CASE WHEN :sender_type = "%customer%"
                        THEN CONCAT(pbg.`name`, " ", pb.`firstname`, " ", pb.`lastname`)
                        ELSE CONCAT(pe.`firstname`, " ", pe.`lastname`)
                        END) LIKE :customer'
                    )
                    ->setParameter('sender_type', '%' . array_shift($filter) . '%')
                    ->setParameter('customer', '%' . implode('_', $filter) . '%');

                continue;
            }

            if ('message' === $filterName) {
                $query->andWhere('p.`message` LIKE :message');
                $query->setParameter('message', '%' . $filter . '%');

                continue;
            }

            if ('active' === $filterName) {
                $query->andWhere('p.`active` LIKE :active');
                $query->setParameter('active', '%' . $filter . '%');

                continue;
            }

            if ('date_add' === $filterName) {
                if (isset($filter['from'])) {
                    $filter['from'] = DateTime::createFromFormat(Context::getContext()->language->date_format_lite, $filter['from']);

                    $query->andWhere('p.`date_add` > :date_add_from');
                    $query->setParameter('date_add_from', $filter['from']->format('Y-m-d') . ' 00:00:00');
                }

                if (isset($filter['to'])) {
                    $filter['to'] = DateTime::createFromFormat(Context::getContext()->language->date_format_lite, $filter['to']);

                    $query->andWhere('p.`date_add` < :date_add_to');
                    $query->setParameter('date_add_to', $filter['to']->format('Y-m-d') . ' 23:59:59');
                }

                continue;
            }

            if ('date_upd' === $filterName) {
                if (isset($filter['from'])) {
                    $filter['from'] = DateTime::createFromFormat(Context::getContext()->language->date_format_lite, $filter['from']);

                    $query->andWhere('p.`date_upd` > :date_upd_from');
                    $query->setParameter('date_upd_from', $filter['from']->format('Y-m-d') . ' 00:00:00');
                }

                if (isset($filter['to'])) {
                    $filter['to'] = DateTime::createFromFormat(Context::getContext()->language->date_format_lite, $filter['to']);

                    $query->andWhere('p.`date_upd` < :date_upd_to');
                    $query->setParameter('date_upd_to', $filter['to']->format('Y-m-d') . ' 23:59:59');
                }

                continue;
            }
        }

        return $query;
    }
}
