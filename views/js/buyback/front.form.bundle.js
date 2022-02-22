/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./buyback/front.form.js ***!
  \*******************************/
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
    $('#input-image').on('click', function() {
        $('#field-image').trigger('click');
    });


    $('#field-image').on('change', function() {
        getImageFieldName(this);
    });
});

function getImageFieldName(field) {
    let count = $(field.files).length;
    let label = $(field).attr('data-multiple-files-text').replace('%count%', count);

    $('#input-image').val(count > 1 ? label : field.files[0].name);
}

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiZnJvbnQuZm9ybS5idW5kbGUuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7O0FBR0w7QUFDQTtBQUNBLEtBQUs7QUFDTCxDQUFDOztBQUVEO0FBQ0E7QUFDQTs7QUFFQTtBQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYWQvYnV5YmFjay8uL2J1eWJhY2svZnJvbnQuZm9ybS5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNpbnB1dC1pbWFnZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcjZmllbGQtaW1hZ2UnKS50cmlnZ2VyKCdjbGljaycpO1xuICAgIH0pO1xuXG5cbiAgICAkKCcjZmllbGQtaW1hZ2UnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGdldEltYWdlRmllbGROYW1lKHRoaXMpO1xuICAgIH0pO1xufSk7XG5cbmZ1bmN0aW9uIGdldEltYWdlRmllbGROYW1lKGZpZWxkKSB7XG4gICAgbGV0IGNvdW50ID0gJChmaWVsZC5maWxlcykubGVuZ3RoO1xuICAgIGxldCBsYWJlbCA9ICQoZmllbGQpLmF0dHIoJ2RhdGEtbXVsdGlwbGUtZmlsZXMtdGV4dCcpLnJlcGxhY2UoJyVjb3VudCUnLCBjb3VudCk7XG5cbiAgICAkKCcjaW5wdXQtaW1hZ2UnKS52YWwoY291bnQgPiAxID8gbGFiZWwgOiBmaWVsZC5maWxlc1swXS5uYW1lKTtcbn1cbiJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==