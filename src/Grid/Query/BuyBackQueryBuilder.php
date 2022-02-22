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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class BuyBackQueryBuilder extends AbstractDoctrineQueryBuilder
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

        $query->select('p.`id_ad_buyback` AS `id`, p.`firstname`, p.`lastname`, p.`email`, p.`description`, p.`active`, p.`date_add`, p.`date_upd`');

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
            ->from($this->dbPrefix . 'ad_buyback', 'p');

        foreach ($filters as $filterName => $filter) {
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
        }

        return $query;
    }
}