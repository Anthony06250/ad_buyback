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

use AdBuyBack\Install\Installer;
use AdBuyBack\Install\InstallerFactory;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ad_BuyBack extends Module implements WidgetInterface
{
    /**
     * Kernel for get services on front office
     * @var AppKernel
     */
    public static $kernel;

    public function __construct()
    {
        $this->name = 'ad_buyback';
        $this->author = 'Anthony DURET';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.7.7.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        $this->tabs = Installer::getTabs();

        parent::__construct();

        $this->displayName = $this->trans('AD - Buy Back', [], 'Modules.Adbuyback.Admin');
        $this->description = $this->trans('Add a buyback features on your shop.', [], 'Modules.Adbuyback.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall ?', [], 'Modules.Adbuyback.Admin');
    }

    /**
     * @return bool
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function install(): bool
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        $installer = InstallerFactory::create($this);

        return parent::install()
            && $installer->install();
    }

    /**
     * @return bool
     */
    public function uninstall(): bool
    {
        $installer = InstallerFactory::create($this);

        return parent::uninstall()
            && $installer->uninstall();
    }

    /**
     * @return void
     */
    public function hookActionFrontControllerSetMedia(): void
    {
        $this->context->controller->registerStylesheet(
            'module-' . $this->name . '-widget',
            'modules/' . '/' . $this->name . '/views/css/front.widget.css',
            ['media' => 'all', 'priority' => 150]
        );
    }

    /**
     * @return string
     */
    public function hookDisplayCustomerAccount(): string
    {
        return $this->render('@Modules/ad_buyback/views/templates/widget/account.html.twig', [
            'link' => $this->context->link->getModuleLink('ad_buyback', 'buyback')
        ]);
    }

    /**
     * @param $hookName
     * @param array $configuration
     * @return string
     */
    public function renderWidget($hookName, array $configuration): string
    {
        return $this->render('@Modules/ad_buyback/views/templates/widget/buyback.html.twig',
            $this->getWidgetVariables($hookName, $configuration)
        );
    }

    /**
     * @param $hookName
     * @param array $configuration
     * @return array
     */
    public function getWidgetVariables($hookName , array $configuration): array
    {
        return [
            'link' => $this->context->link->getModuleLink('ad_buyback', 'form')
        ];
    }

    /**
     * @return AppKernel
     */
    public static function getKernel(): AppKernel
    {
        if (!self::$kernel) {
            global $kernel;

            self::$kernel = $kernel ?? self::loadKernel();
        }

        return self::$kernel;
    }

    /**
     * @return AppKernel
     */
    private static function loadKernel(): AppKernel
    {
        $kernel = new AppKernel(_PS_MODE_DEV_ ? 'dev' : 'prod', _PS_MODE_DEV_);

        $kernel->boot();

        return $kernel;
    }

    /**
     * @param $service
     * @return object|null
     */
    public static function getService($service)
    {
        return self::getKernel()->getContainer()->get($service);
    }

    /**
     * @param mixed $query
     * @return mixed
     */
    public static function handle($query)
    {
        return self::getKernel()->getContainer()->get('prestashop.core.query_bus')->handle($query);
    }

    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    private function render(string $template, array $params): string
    {
        return self::getKernel()->getContainer()->get('twig')->render($template, $params);
    }

    /**
     * @return bool
     */
    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
