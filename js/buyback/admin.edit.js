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
    $('#buyback_edit_image .ad-bb-edit-img').on('click', function () {
        loadImageInModal($(this).find('img').attr('src'));
        loadTitleInModal($(this).find('img').attr('alt'));
    });
});

function loadImageInModal(source) {
    let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');

    $('#buyback-edit-view-modal').find('.ad-bb-modal-figure img').attr('src', source).end()
        .find('.ad-bb-modal-view').attr('href', link);
}

function loadTitleInModal(title) {
    $('#buyback-edit-view-modal').find('.ad-bb-modal-figure img').attr('alt', title).end()
        .find('.ad-bb-modal-figure figcaption').html(title);
}
