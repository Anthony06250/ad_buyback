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

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFja19tZXNzYWdlLmFkbWluLmVkaXQuYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTCxDQUFDOztBQUVEO0FBQ0E7O0FBRUEsaUJBQWlCLGlCQUFpQjtBQUNsQztBQUNBO0FBQ0EsNkJBQTZCLHNCQUFzQjtBQUNuRCxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTCIsInNvdXJjZXMiOlsid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX21lc3NhZ2UvYWRtaW4uZWRpdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2FkX2J1eWJhY2tfY2hhdCcpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgaWYgKCQodGhpcykudmFsKCkpIHtcbiAgICAgICAgICAgIGdldEN1c3RvbWVySW5mbygkKHRoaXMpLnZhbCgpKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG4gICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKHRoaXMpLnZhbCgpKSB7XG4gICAgICAgICAgICAkKCcjYnV5X2JhY2tfbWVzc2FnZV9pZF9lbXBsb3llZScpLnByb3AoJ3NlbGVjdGVkSW5kZXgnLCAwKTtcbiAgICAgICAgfVxuICAgIH0pO1xuXG4gICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfZW1wbG95ZWUnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICgkKHRoaXMpLnZhbCgpKSB7XG4gICAgICAgICAgICAkKCcjYnV5X2JhY2tfbWVzc2FnZV9pZF9jdXN0b21lcicpLnByb3AoJ3NlbGVjdGVkSW5kZXgnLCAwKTtcbiAgICAgICAgfVxuICAgIH0pO1xufSk7XG5cbmZ1bmN0aW9uIGdldEN1c3RvbWVySW5mbyhjaGF0SWQpIHtcbiAgICBsZXQgdXJsID0gJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5hdHRyKCdkYXRhLWN1c3RvbWVyLXVybCcpO1xuXG4gICAgJC5wb3N0KHVybCwgeydjaGF0SWQnOiBjaGF0SWR9LCBmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSlcbiAgICAgICAgICAgID8gZmlsbEN1c3RvbWVySW5wdXQoZGF0YS5tZXNzYWdlKVxuICAgICAgICAgICAgOiAkLmdyb3dsLmVycm9yKHttZXNzYWdlOiBkYXRhLm1lc3NhZ2V9KTtcbiAgICB9LCAnanNvbicpO1xufVxuXG5mdW5jdGlvbiBmaWxsQ3VzdG9tZXJJbnB1dChkYXRhKSB7XG4gICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfaWRfY3VzdG9tZXInKS5maW5kKCdvcHRpb24nKS5zbGljZSgxKS5yZW1vdmUoKS5lbmQoKS5lbmQoKVxuICAgICAgICAuYXBwZW5kKCQoJzxvcHRpb24+Jywge1xuICAgICAgICAgICAgdmFsdWU6IChkYXRhLmlkX2N1c3RvbWVyICE9PSAnMCcpID8gZGF0YS5pZF9jdXN0b21lciA6ICcnLFxuICAgICAgICAgICAgdGV4dDogZGF0YS5mdWxsbmFtZSxcbiAgICAgICAgICAgIHNlbGVjdGVkOiB0cnVlXG4gICAgfSkpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgaWYgKCQodGhpcykudmFsKCkpIHtcbiAgICAgICAgICAgICQoJyNidXlfYmFja19tZXNzYWdlX2lkX2VtcGxveWVlJykucHJvcCgnc2VsZWN0ZWRJbmRleCcsIDApO1xuICAgICAgICB9XG4gICAgfSkudHJpZ2dlcignY2hhbmdlJyk7XG59XG4iXSwibmFtZXMiOltdLCJzb3VyY2VSb290IjoiIn0=