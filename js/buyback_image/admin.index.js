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

$(function () {
    $('#buybackImage_grid_table .ad-bb-grid-img').on('click', function () {
        loadImageInModal($(this).find('img').attr('src'));
        loadTitleInModal($(this).find('img').attr('alt'));
    });

    const grid = new window.prestashop.component.Grid('buybackImage');

    grid.addExtension(new window.prestashop.component.GridExtensions.AsyncToggleColumnExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.BulkActionCheckboxExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.BulkOpenTabsExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ChoiceExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ExportToSqlManagerExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersResetExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersSubmitButtonEnablerExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.LinkRowActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ModalFormSubmitExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.PositionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.PreviewExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ReloadListExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SortingExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitBulkActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitGridActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitRowActionExtension());
});

function loadImageInModal(source) {
    let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');

    $('#buybackImage-grid-view-modal').find('.ad-bb-modal-figure img').attr('src', source).end()
        .find('.ad-bb-modal-view').attr('href', link);
}

function loadTitleInModal(title) {
    $('#buybackImage-grid-view-modal').find('.ad-bb-modal-figure img').attr('alt', title).end()
        .find('.ad-bb-modal-figure figcaption').html(title);
}
