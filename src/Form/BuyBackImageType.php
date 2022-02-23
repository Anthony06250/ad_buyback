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

namespace AdBuyBack\Form;

use AdBuyBack\Domain\BuyBack\Query\GetImageForBuyBack;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Form\Admin\Type\CustomContentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

class BuyBackImageType extends BuyBackType
{
    /**
     * @var CommandBusInterface
     */
    private $queryBus;

    /**
     * @var int
     */
    private $id;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param CommandBusInterface $queryBus
     * @param RequestStack $request
     */
    public function __construct(TranslatorInterface $translator, array $locales, CommandBusInterface $queryBus, RequestStack $request)
    {
        parent::__construct($translator, $locales);
        $this->queryBus = $queryBus;
        $this->id = (int)$request->getCurrentRequest()->get('buybackId');
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $data = $this->queryBus->handle(new GetImageForBuyBack($this->id));
        $directory = 'ad_buyback/views/img/buyback/' . $this->id . '/';

        foreach ($data->getData() as $image) {
            if (file_exists(_PS_MODULE_DIR_ . $directory . $image['name'])) {
                $infos = pathinfo(_MODULE_DIR_ . $directory . $image['name']);

                $builder->add('image-' . $image['id_ad_buyback_image'], CustomContentType::class, [
                    'required' => false,
                    'template' => '@Modules/ad_buyback/views/templates/admin/buyback/image.html.twig',
                    'data' => [
                        'id' => $image['id_ad_buyback_image'],
                        'filename' => $infos['filename'],
                        'extension' => $infos['extension'],
                        'path' => _MODULE_DIR_ . $directory . $image['name'],
                    ]
                ]);
            }
        }
    }
}
