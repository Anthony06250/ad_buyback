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

namespace AdBuyBack\Grid\Factory;

use AdBuyBack\Grid\Action\DeleteBulkAction;
use AdBuyBack\Grid\Action\DisableBulkAction;
use AdBuyBack\Grid\Action\DividerBulkAction;
use AdBuyBack\Grid\Action\DuplicateBulkAction;
use AdBuyBack\Grid\Action\EnableBulkAction;
use AdBuyBack\Model\BuyBackMessage;
use Context;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Action\ModalOptions;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\LinkRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollectionInterface;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DateTimeColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ToggleColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractFilterableGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollectionInterface;
use PrestaShopBundle\Form\Admin\Type\DateRangeType;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use PrestaShopBundle\Form\Admin\Type\YesAndNoChoiceType;
use PrestaShopException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class BuyBackMessageGridDefinitionFactory extends AbstractFilterableGridDefinitionFactory
{
    const GRID_ID = 'buybackMessage';

    /**
     * @return string
     */
    protected function getId(): string
    {
        return self::GRID_ID;
    }

    /**
     * @return string
     */
    protected function getName(): string
    {
        return $this->trans('List of messages', [], 'Modules.Adbuyback.Admin');
    }

    /**
     * @return ColumnCollection|ColumnCollectionInterface
     */
    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add((new BulkActionColumn('bulk_action'))
                ->setOptions(['bulk_field' => 'id'])
            )
            ->add((new DataColumn('id'))
                ->setName($this->trans('ID', [], 'Modules.Adbuyback.Admin'))
                ->setOptions(['field' => 'id'])
            )
            ->add((new DataColumn('id_ad_buyback_chat'))
                ->setName($this->trans('Chat', [], 'Modules.Adbuyback.Admin'))
                ->setOptions(['field' => 'id_ad_buyback_chat'])
            )
            ->add((new DataColumn('sender'))
                ->setName($this->trans('Sender', [], 'Modules.Adbuyback.Admin'))
                ->setOptions(['field' => 'sender'])
            )
            ->add((new DataColumn('message'))
                ->setName($this->trans('Message', [], 'Modules.Adbuyback.Admin'))
                ->setOptions(['field' => 'message'])
            )
            ->add((new ToggleColumn('active'))
                ->setName($this->trans('Status', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'field' => 'active',
                    'primary_field' => 'id',
                    'route' => 'admin_ad_buyback_message_active',
                    'route_param_name' => 'messageId'
                ])
            )
            ->add((new DateTimeColumn('date_add'))
                ->setName($this->trans('Created', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'field' => 'date_add',
                    'format' => Context::getContext()->language->date_format_full
                ])
            )
            ->add((new DateTimeColumn('date_upd'))
                ->setName($this->trans('Updated', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'field' => 'date_upd',
                    'format' => Context::getContext()->language->date_format_full
                ])
            )
            ->add((new ActionColumn('actions'))
                ->setName($this->trans('Actions', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'actions' => (new RowActionCollection())
                        ->add((new LinkRowAction('chat'))
                            ->setName($this->trans('View chat', [], 'Modules.Adbuyback.Admin'))
                            ->setIcon('chat')
                            ->setOptions([
                                'route' => 'admin_ad_buyback_chat_view',
                                'route_param_name' => 'chatId',
                                'route_param_field' => 'id_ad_buyback_chat',
                            ])
                        )
                        ->add((new LinkRowAction('edit'))
                            ->setName($this->trans('Edit', [], 'Modules.Adbuyback.Admin'))
                            ->setIcon('edit')
                            ->setOptions([
                                'route' => 'admin_ad_buyback_message_edit',
                                'route_param_name' => 'messageId',
                                'route_param_field' => 'id',
                                'clickable_row' => true
                            ])
                        )
                        ->add((new SubmitRowAction('delete'))
                            ->setName($this->trans('Delete', [], 'Modules.Adbuyback.Admin'))
                            ->setIcon('delete')
                            ->setOptions([
                                'method' => 'POST',
                                'route' => 'admin_ad_buyback_message_delete',
                                'route_param_name' => 'messageId',
                                'route_param_field' => 'id',
                                'confirm_message' => $this->trans('Are you sure you want to delete this message ?', [], 'Modules.Adbuyback.Alert'),
                                'modal_options' => new ModalOptions([
                                    'title' => $this->trans('Delete message', [], 'Modules.Adbuyback.Admin'),
                                    'confirm_button_label' => $this->trans('Delete', [], 'Modules.Adbuyback.Admin'),
                                    'confirm_button_class' => 'btn-danger',
                                    'close_button_label' => $this->trans('Close', [], 'Modules.Adbuyback.Admin')
                                ])
                            ])
                        )
                ])
            );
    }

    /**
     * @return FilterCollection|FilterCollectionInterface
     * @throws PrestaShopException
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add((new Filter('id_ad_buyback_chat', ChoiceType::class))
                ->setAssociatedColumn('id_ad_buyback_chat')
                ->setTypeOptions([
                    'required' => false,
                    'choices' => BuyBackMessage::getChatsList()
                ])
            )
            ->add((new Filter('sender', ChoiceType::class))
                ->setAssociatedColumn('sender')
                ->setTypeOptions([
                    'required' => false,
                    'choices' => BuyBackMessage::getSendersList()
                ])
            )
            ->add((new Filter('message', TextType::class))
                ->setAssociatedColumn('message')
                ->setTypeOptions([
                    'required' => false,
                    'attr' => ['placeholder' => $this->trans('Search', [], 'Modules.Adbuyback.Admin')]
                ])
            )
            ->add((new Filter('active', YesAndNoChoiceType::class))
                ->setAssociatedColumn('active')
            )
            ->add((new Filter('date_add', DateRangeType::class))
                ->setAssociatedColumn('date_add')
                ->setTypeOptions([
                    'date_format' => str_replace(['Y', 'm', 'd'], ['YYYY', 'MM', 'DD'], Context::getContext()->language->date_format_lite),
                ])
            )
            ->add((new Filter('date_upd', DateRangeType::class))
                ->setAssociatedColumn('date_upd')
                ->setTypeOptions([
                    'date_format' => str_replace(['Y', 'm', 'd'], ['YYYY', 'MM', 'DD'], Context::getContext()->language->date_format_lite),
                ])
            )
            ->add((new Filter('actions', SearchAndResetType::class))
                ->setAssociatedColumn('actions')
                ->setTypeOptions([
                    'reset_route' => 'admin_common_reset_search_by_filter_id',
                    'reset_route_params' => ['filterId' => self::GRID_ID],
                    'redirect_route' => 'admin_ad_buyback_message_index'
                ])
            );
    }

    /**
     * @return BulkActionCollection|BulkActionCollectionInterface
     */
    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add((new EnableBulkAction('enable_selection'))
                ->setName($this->trans('Enable selection', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_buyback_message_active_bulk',
                    'route_params' => ['status' => true],
                    'confirm_message' => $this->trans('Are you sure you want to enable the selected message(s) ?', [], 'Modules.Adbuyback.Alert'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Enable message(s) selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_label' => $this->trans('Enable selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_class' => 'btn-success'
                    ])
                ])
            )
            ->add((new DisableBulkAction('disable_selection'))
                ->setName($this->trans('Disable selection', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_buyback_message_active_bulk',
                    'route_params' => ['status' => false],
                    'confirm_message' => $this->trans('Are you sure you want to disable the selected message(s) ?', [], 'Modules.Adbuyback.Alert'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Disable message(s) selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_label' => $this->trans('Disable selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_class' => 'btn-warning'
                    ])
                ])
            )
            ->add(new DividerBulkAction('divider1'))
            ->add((new DuplicateBulkAction('duplicate_selection'))
                ->setName($this->trans('Duplicate selection', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_buyback_message_duplicate_bulk',
                    'confirm_message' => $this->trans('Are you sure you want to duplicate the selected message(s) ?', [], 'Modules.Adbuyback.Alert'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Duplicate message(s) selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_label' => $this->trans('Duplicate selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_class' => 'btn-success'
                    ])
                ])
            )
            ->add(new DividerBulkAction('divider2'))
            ->add((new DeleteBulkAction('delete_selection'))
                ->setName($this->trans('Delete selection', [], 'Modules.Adbuyback.Admin'))
                ->setOptions([
                    'submit_route' => 'admin_ad_buyback_message_delete_bulk',
                    'confirm_message' => $this->trans('Are you sure you want to delete the selected message(s) ?', [], 'Modules.Adbuyback.Alert'),
                    'modal_options' => new ModalOptions([
                        'title' => $this->trans('Delete message(s) selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_label' => $this->trans('Delete selection', [], 'Modules.Adbuyback.Admin'),
                        'confirm_button_class' => 'btn-danger'
                    ])
                ])
            );
    }
}
