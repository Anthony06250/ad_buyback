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
    let customerInfos = new CustomerInfos();

    $('#buy_back_message_id_ad_buyback_chat').on('change', function() {
        ($(this).val())
            ? customerInfos.getCustomerInfos(this)
            : customerInfos.disableUnnecessaryOptions();
    });

    $('#buy_back_message_id_customer').on('change', function() {
        if ($(this).val()) {
            $('#buy_back_message_id_employee').prop('selectedIndex', 0);
        }
    });

    $('#buy_back_message_id_employee').on('change', function() {
        if ($(this).val()) {
            $('#buy_back_message_id_customer').prop('selectedIndex', 0);
        }
    });
});

class CustomerInfos {
    constructor() {
        this.disableUnnecessaryOptions();
        this.init();
    }

    init() {
        let defaultChat = $('#buy_back_message_id_ad_buyback_chat option:selected');

        if (defaultChat.val()) {
            this.getCustomerInfos(defaultChat);
        }
    }

    getCustomerInfos(trigger) {
        let url = $('#buy_back_message_id_customer').attr('data-customer-url');
        let self = this;

        $.post(url, {'chatId': $(trigger).val()}, function(data) {
            (data.status === true)
                ? self.fillCustomerSelect(data.message)
                : $.growl.error({message: data.message});
        }, 'json');
    }

    fillCustomerSelect(data) {
        this.enableNecessaryOptions(data.id_customer);
        this.disableUnnecessaryOptions(data.id_customer);
        this.removeVisitorOption();
        if (data.id_customer === '0') {
            this.addVisitorOption(data.fullname);
        }
    }

    enableNecessaryOptions(necessary) {
        $('#buy_back_message_id_customer').find('option[value=' + necessary + ']').show();
    }

    disableUnnecessaryOptions(necessary) {
        $('#buy_back_message_id_customer').prop('selectedIndex', 0).find('option[value!=' + necessary + ']').slice(1).hide();
    }

    addVisitorOption(visitor) {
        $('#buy_back_message_id_customer').append(new Option(visitor, ''));
    }

    removeVisitorOption() {
        $('#buy_back_message_id_customer').find('option[value!=""]').slice(1).remove();
    }
}
