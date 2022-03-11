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

export default class ImageModal {
    constructor(modal) {
        this.modal = $('#' + modal);
    }

    loadImageModal(trigger) {
        this.fillImageInModal($(trigger));
        this.fillTitleInModal($(trigger));
        this.modal.modal('show');
    }

    fillImageInModal(trigger) {
        let source = trigger.find('img').attr('src');
        let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');
        let button = $('.ad-bb-modal-view');

        $('.ad-bb-modal-figure img').attr('src', source);
        (source.split(':')[0] !== 'data')
            ? button.attr('href', link).removeClass('hidden')
            : button.attr('href', '').addClass('hidden');
    }

    fillTitleInModal(trigger) {
        let title = trigger.find('img').attr('alt');

        this.modal.find('.ad-bb-modal-figure img').attr('alt', title).end()
            .find('.ad-bb-modal-figure figcaption').html(title);
    }
}
