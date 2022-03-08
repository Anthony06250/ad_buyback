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

import ImageModal from '../buyback_image/admin.modal';

$(function () {
    let modal = new ImageModal('buyback-edit-view-modal');
    let customerInfos = new CustomerInfos();

    $('#buy_back_id_customer').on('change', function() {
        customerInfos.getCustomerInfos(this);
    });

    $('.ad-bb-admin-img-btn').on('click', function () {
        modal.loadImageModal(this);
    });
});

class CustomerInfos {
    constructor() {
        this.defaultCustomer = {
            'id_gender': $('#buy_back_id_gender').val(),
            'firstname': $('#buy_back_firstname').val(),
            'lastname': $('#buy_back_lastname').val(),
            'email': $('#buy_back_email').val()
        };
        this.init();
    }

    init() {
        if ($('#buy_back_id_customer option:selected').val()) {
            this.readOnlyInputs(true);
        }
    }

    getCustomerInfos(trigger) {
        let url = $('#buy_back_id_customer').attr('data-customer-url');
        let self = this;

        $.post(url, {'buybackId': $(trigger).val()}, function(data) {
            (data.status === true)
                ? self.fillCustomerInputs(data.message)
                : $.growl.error({message: data.message});
        }, 'json');
    }

    fillCustomerInputs(data) {
        $('#buy_back_id_gender').prop('selectedIndex', data ? data['id_gender'] : this.defaultCustomer.id_gender);
        $('#buy_back_firstname').val(data ? data['firstname'] : this.defaultCustomer.firstname);
        $('#buy_back_lastname').val(data ? data['lastname'] : this.defaultCustomer.lastname);
        $('#buy_back_email').val(data ? data['email'] : this.defaultCustomer.email);
        this.readOnlyInputs((data));
    }

    readOnlyInputs(readonly) {
        let inputIdGender = $('#buy_back_id_gender');

        readonly ? inputIdGender.addClass('readonly') : inputIdGender.removeClass('readonly')
        $('#buy_back_firstname').attr('readonly', readonly);
        $('#buy_back_lastname').attr('readonly', readonly);
        $('#buy_back_email').attr('readonly', readonly);
    }
}
