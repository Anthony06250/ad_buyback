/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./buyback_chat/admin.view.js ***!
  \************************************/
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
    $('html, body').animate({
        scrollTop: $('.ad-bb-message').last().offset().top
            - $('.header-toolbar').height()
            - $('#header_infos').height()
    }, 1000);

    $('.card-header .ps-switch').on('change', function() {
        toggleActiveChat(this);
    });

    $('.ad-bb-message .ps-switch').on('change', function() {
        toggleActiveMessage(this);
    });
});

function toggleActiveChat(chat) {
    let url = $(chat).attr('data-toggle-url');

    $.post(url, function(data) {
        if (data.status === true) {
            $.growl({message: data.message});
            disableTextarea($(chat).find('input:checked').val());
        } else {
            $.growl.error({message: data.message});
        }
    }, 'json');
}

function disableTextarea(status) {
    $('#buy_back_message_message').attr('disabled', (status  === '0'));
    $('button:submit').attr('disabled', (status  === '0'));
}

function toggleActiveMessage(message) {
    let url = $(message).attr('data-toggle-url');

    $.post(url, function(data) {
        (data.status === true)
            ? $.growl({message: data.message})
            : $.growl.error({message: data.message});
    }, 'json');
}

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFja19jaGF0LmFkbWluLnZpZXcuYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLO0FBQ0wsQ0FBQzs7QUFFRDtBQUNBOztBQUVBO0FBQ0E7QUFDQSxxQkFBcUIsc0JBQXNCO0FBQzNDO0FBQ0EsVUFBVTtBQUNWLDJCQUEyQixzQkFBc0I7QUFDakQ7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsdUJBQXVCLHNCQUFzQjtBQUM3Qyw2QkFBNkIsc0JBQXNCO0FBQ25ELEtBQUs7QUFDTCIsInNvdXJjZXMiOlsid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX2NoYXQvYWRtaW4udmlldy5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgICQoJ2h0bWwsIGJvZHknKS5hbmltYXRlKHtcbiAgICAgICAgc2Nyb2xsVG9wOiAkKCcuYWQtYmItbWVzc2FnZScpLmxhc3QoKS5vZmZzZXQoKS50b3BcbiAgICAgICAgICAgIC0gJCgnLmhlYWRlci10b29sYmFyJykuaGVpZ2h0KClcbiAgICAgICAgICAgIC0gJCgnI2hlYWRlcl9pbmZvcycpLmhlaWdodCgpXG4gICAgfSwgMTAwMCk7XG5cbiAgICAkKCcuY2FyZC1oZWFkZXIgLnBzLXN3aXRjaCcpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgdG9nZ2xlQWN0aXZlQ2hhdCh0aGlzKTtcbiAgICB9KTtcblxuICAgICQoJy5hZC1iYi1tZXNzYWdlIC5wcy1zd2l0Y2gnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIHRvZ2dsZUFjdGl2ZU1lc3NhZ2UodGhpcyk7XG4gICAgfSk7XG59KTtcblxuZnVuY3Rpb24gdG9nZ2xlQWN0aXZlQ2hhdChjaGF0KSB7XG4gICAgbGV0IHVybCA9ICQoY2hhdCkuYXR0cignZGF0YS10b2dnbGUtdXJsJyk7XG5cbiAgICAkLnBvc3QodXJsLCBmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgIGlmIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSkge1xuICAgICAgICAgICAgJC5ncm93bCh7bWVzc2FnZTogZGF0YS5tZXNzYWdlfSk7XG4gICAgICAgICAgICBkaXNhYmxlVGV4dGFyZWEoJChjaGF0KS5maW5kKCdpbnB1dDpjaGVja2VkJykudmFsKCkpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJC5ncm93bC5lcnJvcih7bWVzc2FnZTogZGF0YS5tZXNzYWdlfSk7XG4gICAgICAgIH1cbiAgICB9LCAnanNvbicpO1xufVxuXG5mdW5jdGlvbiBkaXNhYmxlVGV4dGFyZWEoc3RhdHVzKSB7XG4gICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfbWVzc2FnZScpLmF0dHIoJ2Rpc2FibGVkJywgKHN0YXR1cyAgPT09ICcwJykpO1xuICAgICQoJ2J1dHRvbjpzdWJtaXQnKS5hdHRyKCdkaXNhYmxlZCcsIChzdGF0dXMgID09PSAnMCcpKTtcbn1cblxuZnVuY3Rpb24gdG9nZ2xlQWN0aXZlTWVzc2FnZShtZXNzYWdlKSB7XG4gICAgbGV0IHVybCA9ICQobWVzc2FnZSkuYXR0cignZGF0YS10b2dnbGUtdXJsJyk7XG5cbiAgICAkLnBvc3QodXJsLCBmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSlcbiAgICAgICAgICAgID8gJC5ncm93bCh7bWVzc2FnZTogZGF0YS5tZXNzYWdlfSlcbiAgICAgICAgICAgIDogJC5ncm93bC5lcnJvcih7bWVzc2FnZTogZGF0YS5tZXNzYWdlfSk7XG4gICAgfSwgJ2pzb24nKTtcbn1cbiJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==