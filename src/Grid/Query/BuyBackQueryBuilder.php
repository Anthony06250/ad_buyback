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

final class BuyBackQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var int
     */
    private $contextLanguageId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param int $contextLanguageId
     * @param int $contextShopId
     * @param DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator
     */
    public function __construct(Connection $connection, string $dbPrefix, int $contextLanguageId, int $contextShopId, DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator)
    {
        parent::__construct($connection, $dbPrefix);
        $this->contextLanguageId = $contextLanguageId;
        $this->contextShopId = $contextShopId;
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QueryBuilder
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $query = $this->getQueryBuilder($searchCriteria->getFilters());

        $query->select('p.`id_ad_buyback` AS `id`, p.`firstname`, p.`lastname`, p.`email`, p.`description`, p.`active`, p.`date_add`, p.`date_upd`')
            ->addSelect('ps.`name` AS `gender`');

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
        $query->select('COUNT(p.`id_ad_buyback`)');

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
            ->from($this->dbPrefix . 'ad_buyback', 'p')
            ->innerJoin('p',
                $this->dbPrefix . 'gender_lang',
                'ps',
                'ps.`id_gender` = p.`id_gender` AND ps.`id_lang` = :id_lang'
            )
            ->setParameter('id_lang', $this->contextLanguageId);

        foreach ($filters as $filterName => $filter) {
            if ('id_gender' === $filterName) {
                $query->andWhere('ps.`id_gender` LIKE :id_gender');
                $query->setParameter('id_gender', '%' . $filter . '%');

                continue;
            }

            if ('firstname' === $filterName) {
                $query->andWhere('p.`firstname` LIKE :firstname');
                $query->setParameter('firstname', '%' . $filter . '%');

                continue;
            }

            if ('lastname' === $filterName) {
                $query->andWhere('p.`lastname` LIKE :lastname');
                $query->setParameter('lastname', '%' . $filter . '%');

                continue;
            }

            if ('email' === $filterName) {
                $query->andWhere('p.`email` LIKE :email');
                $query->setParameter('email', '%' . $filter . '%');

                continue;
            }

            if ('description' === $filterName) {
                $query->andWhere('p.`description` LIKE :description');
                $query->setParameter('description', '%' . $filter . '%');

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
