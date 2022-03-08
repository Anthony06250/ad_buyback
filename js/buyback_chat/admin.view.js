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

import Modal from '../buyback/admin.modal';

$(function () {
    let modal = new Modal('buyback-chat-modal');
    let chatActions = new ChatActions();
    let messageActions = new MessageActions();

    $('html, body').animate({
        scrollTop: $('.ad-bb-admin-message').last().offset().top
            - $('.header-toolbar').height()
            - $('#header_infos').height()
    }, 1000);

    $('.ad-bb-admin-chat-actions .ps-switch').on('change', function() {
        chatActions.toggleActiveChat(this);
    });

    $('.ad-bb-admin-msg-actions .ps-switch').on('change', function() {
        messageActions.toggleActiveMessage(this);
    });

    $('.ad-bb-admin-chat-actions-delete, .ad-bb-admin-msg-actions-delete').on('click', function () {
        modal.show(this);
    });
});

class ChatActions {
    toggleActiveChat(chat) {
        let url = $(chat).attr('data-toggle-url');
        let self = this;

        $.post(url, function(data) {
            if (data.status === true) {
                $.growl({message: data.message});
                self.disableTextarea($(chat).find('input:checked').val());
            } else {
                $.growl.error({message: data.message});
            }
        }, 'json');
    }

    disableTextarea(status) {
        $('#buy_back_message_message').attr('disabled', (status  === '0'));
        $('button:submit').attr('disabled', (status  === '0'));
    }
}

class MessageActions {
    toggleActiveMessage(message) {
        let url = $(message).attr('data-toggle-url');

        $.post(url, function(data) {
            (data.status === true)
                ? $.growl({message: data.message})
                : $.growl.error({message: data.message});
        }, 'json');
    }
}
