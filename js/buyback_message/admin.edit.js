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
    $('#buy_back_message_id_ad_buyback_chat').on('change', function() {
        if ($(this).val()) {
            getCustomerInfo($(this).val());
        }
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

function getCustomerInfo(chatId) {
    let url = $('#buy_back_message_id_customer').attr('data-customer-url');

    $.post(url, {'chatId': chatId}, function(data) {
        (data.status === true)
            ? fillCustomerInput(data.message)
            : $.growl.error({message: data.message});
    }, 'json');
}

function fillCustomerInput(data) {
    $('#buy_back_message_id_customer').find('option').slice(1).remove().end().end()
        .append($('<option>', {
            value: (data.id_customer !== '0') ? data.id_customer : '',
            text: data.fullname,
            selected: true
    })).on('change', function() {
        if ($(this).val()) {
            $('#buy_back_message_id_employee').prop('selectedIndex', 0);
        }
    }).trigger('change');
}
