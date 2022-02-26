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

namespace AdBuyBack\Install;

use AdBuyBack\Tools\BuyBackTools;
use Context;
use Db;
use Language;
use Module;
use PrestaShopException;
use Tools;

class Installer
{
    /**
     * @var Module
     */
    private $module;

    /**
     * @var FixturesInstaller
     */
    private $fixturesInstaller;

    /**
     * @param Module $module
     * @param FixturesInstaller $fixturesInstaller
     */
    public function __construct(Module $module, FixturesInstaller $fixturesInstaller)
    {
        $this->module = $module;
        $this->fixturesInstaller = $fixturesInstaller;
    }

    /**
     * @return bool
     * @throws PrestaShopException
     */
    public function install(): bool
    {
        if (!$this->registerHooks()
            || !$this->installDatabase()
            || !$this->createImageDirectory()) {
            return false;
        }

        $this->fixturesInstaller->install();

        return true;
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        return $this->uninstallDatabase()
            && $this->deleteImageDirectory();
    }

    /**
     * @return bool
     */
    private function registerHooks(): bool
    {
        $hooks = [
            'actionFrontControllerSetMedia',
            'displayHome'
        ];

        return $this->module->registerHook($hooks);
    }

    /**
     * @return bool
     */
    private function installDatabase(): bool
    {
        $file = dirname(__FILE__) . '/Sql/install.sql';

        return file_exists($file) && $this->loadSqlFile($file);
    }

    /**
     * @return bool
     */
    private function uninstallDatabase(): bool
    {
        $file = dirname(__FILE__) . '/Sql/uninstall.sql';

        return file_exists($file) && $this->loadSqlFile($file);
    }

    /**
     * @param string $file
     * @return bool
     */
    private function loadSqlFile(string $file): bool
    {
        $queries = Tools::file_get_contents($file);
        $queries = str_replace(array('PREFIX_', 'ENGINE_TYPE'), array(_DB_PREFIX_, _MYSQL_ENGINE_), $queries);
        $queries = preg_split("/;\s*[\r\n]+/", $queries);

        return $this->executeQueries($queries);
    }

    /**
     * @param array $queries
     * @return bool
     */
    private function executeQueries(array $queries): bool
    {
        $result = true;

        foreach ($queries as $query) {
            if (!empty($query)) {
                $result &= Db::getInstance()->execute(trim($query));
            }
        }

        return true; // -> TODO: FIX ambiguous return
    }

    /**
     * @return bool
     */
    private function createImageDirectory(): bool
    {
        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/';

        BuyBackTools::createDirectory($directory);

        return true;
    }

    /**
     * @return bool
     */
    private function deleteImageDirectory(): bool
    {
        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/';

        BuyBackTools::deleteDirectory($directory);

        return true;
    }

    /**
     * @return array[]
     */
    public static function getTabs(): array
    {
        $tabNames = [];

        foreach (Language::getLanguages(true) as $lang) {
            $tabNames[$lang['locale']] = Context::getContext()->getTranslator()->trans('Buybacks', [], 'Modules.Adbuyback.Admin', $lang['locale']);
        }

        return [
            [
                'route_name' => 'admin_ad_buyback_index',
                'class_name' => 'AdminBuyBack',
                'visible' => true,
                'name' => $tabNames,
                'parent_class_name' => 'AdminParentCustomer',
                'wording' => 'Buybacks',
                'wording_domain' => 'Modules.Adbuyback.Admin'
            ],
        ];
    }
}
