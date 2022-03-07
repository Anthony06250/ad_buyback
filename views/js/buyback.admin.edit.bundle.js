/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./buyback/admin.edit.js ***!
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
    $('#buyback_edit_image .ad-bb-edit-img').on('click', function () {
        loadImageInModal($(this).find('img').attr('src'));
        loadTitleInModal($(this).find('img').attr('alt'));
    });
});

function loadImageInModal(source) {
    let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');

    $('#buyback-edit-view-modal').find('.ad-bb-modal-figure img').attr('src', source).end()
        .find('.ad-bb-modal-view').attr('href', link);
}

function loadTitleInModal(title) {
    $('#buyback-edit-view-modal').find('.ad-bb-modal-figure img').attr('alt', title).end()
        .find('.ad-bb-modal-figure figcaption').html(title);
}

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFjay5hZG1pbi5lZGl0LmJ1bmRsZS5qcyIsIm1hcHBpbmdzIjoiOzs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTCxDQUFDOztBQUVEO0FBQ0EsMkRBQTJELGdDQUFnQzs7QUFFM0Y7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYWQvYnV5YmFjay8uL2J1eWJhY2svYWRtaW4uZWRpdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgICQoJyNidXliYWNrX2VkaXRfaW1hZ2UgLmFkLWJiLWVkaXQtaW1nJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBsb2FkSW1hZ2VJbk1vZGFsKCQodGhpcykuZmluZCgnaW1nJykuYXR0cignc3JjJykpO1xuICAgICAgICBsb2FkVGl0bGVJbk1vZGFsKCQodGhpcykuZmluZCgnaW1nJykuYXR0cignYWx0JykpO1xuICAgIH0pO1xufSk7XG5cbmZ1bmN0aW9uIGxvYWRJbWFnZUluTW9kYWwoc291cmNlKSB7XG4gICAgbGV0IGxpbmsgPSBzb3VyY2Uuc3BsaXQoJy8nKS5maWx0ZXIoZnVuY3Rpb24oZWxlbWVudCkge3JldHVybiBlbGVtZW50ICE9PSAndGh1bWJuYWlsJzt9KS5qb2luKCcvJyk7XG5cbiAgICAkKCcjYnV5YmFjay1lZGl0LXZpZXctbW9kYWwnKS5maW5kKCcuYWQtYmItbW9kYWwtZmlndXJlIGltZycpLmF0dHIoJ3NyYycsIHNvdXJjZSkuZW5kKClcbiAgICAgICAgLmZpbmQoJy5hZC1iYi1tb2RhbC12aWV3JykuYXR0cignaHJlZicsIGxpbmspO1xufVxuXG5mdW5jdGlvbiBsb2FkVGl0bGVJbk1vZGFsKHRpdGxlKSB7XG4gICAgJCgnI2J1eWJhY2stZWRpdC12aWV3LW1vZGFsJykuZmluZCgnLmFkLWJiLW1vZGFsLWZpZ3VyZSBpbWcnKS5hdHRyKCdhbHQnLCB0aXRsZSkuZW5kKClcbiAgICAgICAgLmZpbmQoJy5hZC1iYi1tb2RhbC1maWd1cmUgZmlnY2FwdGlvbicpLmh0bWwodGl0bGUpO1xufVxuIl0sIm5hbWVzIjpbXSwic291cmNlUm9vdCI6IiJ9