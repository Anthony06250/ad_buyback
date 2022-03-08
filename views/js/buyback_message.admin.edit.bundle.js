/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./buyback_message/admin.edit.js ***!
  \***************************************/
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

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFja19tZXNzYWdlLmFkbWluLmVkaXQuYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTCxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEscUJBQXFCLDJCQUEyQjtBQUNoRDtBQUNBO0FBQ0EsaUNBQWlDLHNCQUFzQjtBQUN2RCxTQUFTO0FBQ1Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSIsInNvdXJjZXMiOlsid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX21lc3NhZ2UvYWRtaW4uZWRpdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgIGxldCBjdXN0b21lckluZm9zID0gbmV3IEN1c3RvbWVySW5mb3MoKTtcblxuICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2FkX2J1eWJhY2tfY2hhdCcpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgKCQodGhpcykudmFsKCkpXG4gICAgICAgICAgICA/IGN1c3RvbWVySW5mb3MuZ2V0Q3VzdG9tZXJJbmZvcyh0aGlzKVxuICAgICAgICAgICAgOiBjdXN0b21lckluZm9zLmRpc2FibGVVbm5lY2Vzc2FyeU9wdGlvbnMoKTtcbiAgICB9KTtcblxuICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2N1c3RvbWVyJykub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xuICAgICAgICBpZiAoJCh0aGlzKS52YWwoKSkge1xuICAgICAgICAgICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfZW1wbG95ZWUnKS5wcm9wKCdzZWxlY3RlZEluZGV4JywgMCk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2VtcGxveWVlJykub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xuICAgICAgICBpZiAoJCh0aGlzKS52YWwoKSkge1xuICAgICAgICAgICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5wcm9wKCdzZWxlY3RlZEluZGV4JywgMCk7XG4gICAgICAgIH1cbiAgICB9KTtcbn0pO1xuXG5jbGFzcyBDdXN0b21lckluZm9zIHtcbiAgICBjb25zdHJ1Y3RvcigpIHtcbiAgICAgICAgdGhpcy5kaXNhYmxlVW5uZWNlc3NhcnlPcHRpb25zKCk7XG4gICAgICAgIHRoaXMuaW5pdCgpO1xuICAgIH1cblxuICAgIGluaXQoKSB7XG4gICAgICAgIGxldCBkZWZhdWx0Q2hhdCA9ICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2FkX2J1eWJhY2tfY2hhdCBvcHRpb246c2VsZWN0ZWQnKTtcblxuICAgICAgICBpZiAoZGVmYXVsdENoYXQudmFsKCkpIHtcbiAgICAgICAgICAgIHRoaXMuZ2V0Q3VzdG9tZXJJbmZvcyhkZWZhdWx0Q2hhdCk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBnZXRDdXN0b21lckluZm9zKHRyaWdnZXIpIHtcbiAgICAgICAgbGV0IHVybCA9ICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2N1c3RvbWVyJykuYXR0cignZGF0YS1jdXN0b21lci11cmwnKTtcbiAgICAgICAgbGV0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgICQucG9zdCh1cmwsIHsnY2hhdElkJzogJCh0cmlnZ2VyKS52YWwoKX0sIGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgICAgICAgIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSlcbiAgICAgICAgICAgICAgICA/IHNlbGYuZmlsbEN1c3RvbWVyU2VsZWN0KGRhdGEubWVzc2FnZSlcbiAgICAgICAgICAgICAgICA6ICQuZ3Jvd2wuZXJyb3Ioe21lc3NhZ2U6IGRhdGEubWVzc2FnZX0pO1xuICAgICAgICB9LCAnanNvbicpO1xuICAgIH1cblxuICAgIGZpbGxDdXN0b21lclNlbGVjdChkYXRhKSB7XG4gICAgICAgIHRoaXMuZW5hYmxlTmVjZXNzYXJ5T3B0aW9ucyhkYXRhLmlkX2N1c3RvbWVyKTtcbiAgICAgICAgdGhpcy5kaXNhYmxlVW5uZWNlc3NhcnlPcHRpb25zKGRhdGEuaWRfY3VzdG9tZXIpO1xuICAgICAgICB0aGlzLnJlbW92ZVZpc2l0b3JPcHRpb24oKTtcbiAgICAgICAgaWYgKGRhdGEuaWRfY3VzdG9tZXIgPT09ICcwJykge1xuICAgICAgICAgICAgdGhpcy5hZGRWaXNpdG9yT3B0aW9uKGRhdGEuZnVsbG5hbWUpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgZW5hYmxlTmVjZXNzYXJ5T3B0aW9ucyhuZWNlc3NhcnkpIHtcbiAgICAgICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5maW5kKCdvcHRpb25bdmFsdWU9JyArIG5lY2Vzc2FyeSArICddJykuc2hvdygpO1xuICAgIH1cblxuICAgIGRpc2FibGVVbm5lY2Vzc2FyeU9wdGlvbnMobmVjZXNzYXJ5KSB7XG4gICAgICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2N1c3RvbWVyJykucHJvcCgnc2VsZWN0ZWRJbmRleCcsIDApLmZpbmQoJ29wdGlvblt2YWx1ZSE9JyArIG5lY2Vzc2FyeSArICddJykuc2xpY2UoMSkuaGlkZSgpO1xuICAgIH1cblxuICAgIGFkZFZpc2l0b3JPcHRpb24odmlzaXRvcikge1xuICAgICAgICAkKCcjYnV5X2JhY2tfbWVzc2FnZV9pZF9jdXN0b21lcicpLmFwcGVuZChuZXcgT3B0aW9uKHZpc2l0b3IsICcnKSk7XG4gICAgfVxuXG4gICAgcmVtb3ZlVmlzaXRvck9wdGlvbigpIHtcbiAgICAgICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5maW5kKCdvcHRpb25bdmFsdWUhPVwiXCJdJykuc2xpY2UoMSkucmVtb3ZlKCk7XG4gICAgfVxufVxuIl0sIm5hbWVzIjpbXSwic291cmNlUm9vdCI6IiJ9