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

export default class Modal {
    constructor(modal) {
        this.modal = $('#' + modal);
        this.trigger = null;
        this.init();
    }

    init() {
        let self = this;

        this.modal.find('.btn-confirm-submit').on('click', function () {
            self.submitForm();
        });
    }

    show(trigger) {
        this.trigger = $(trigger);
        this.fillModal();
        this.modal.modal('show');
    }

    fillModal() {
        this.modal.find('.modal-title').html(this.trigger.attr('data-title'));
        this.modal.find('.confirm-message').text(this.trigger.attr('data-confirm-message'));
        this.modal.find('.modal-footer button:first').text(this.trigger.attr('data-close-button-label'));
        this.modal.find('.btn-confirm-submit').text(this.trigger.attr('data-confirm-button-label'))
            .removeClass('btn-success', 'btn-danger', 'btn-warning', 'btn-info', 'btn-primary', 'btn-secondary')
            .addClass(this.trigger.attr('data-confirm-button-class') ?? 'btn-primary');
    }

    submitForm() {
        $('<form>').attr('action', this.trigger.attr('data-url')).attr('method', 'POST')
            .appendTo('body').submit();
    }
}
