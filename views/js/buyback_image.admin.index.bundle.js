/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./buyback_image/admin.index.js ***!
  \**************************************/
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
    $('#buybackImage_grid_table .ad-bb-grid-img').on('click', function () {
        loadImageInModal($(this).find('img').attr('src'));
        loadTitleInModal($(this).find('img').attr('alt'));
    });

    const grid = new window.prestashop.component.Grid('buybackImage');

    grid.addExtension(new window.prestashop.component.GridExtensions.AsyncToggleColumnExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.BulkActionCheckboxExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.BulkOpenTabsExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ChoiceExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ExportToSqlManagerExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersResetExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersSubmitButtonEnablerExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.LinkRowActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ModalFormSubmitExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.PositionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.PreviewExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.ReloadListExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SortingExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitBulkActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitGridActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitRowActionExtension());
});

function loadImageInModal(source) {
    let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');

    $('#buybackImage-grid-view-modal').find('.ad-bb-modal-figure img').attr('src', source).end()
        .find('.ad-bb-modal-view').attr('href', link);
}

function loadTitleInModal(title) {
    $('#buybackImage-grid-view-modal').find('.ad-bb-modal-figure img').attr('alt', title).end()
        .find('.ad-bb-modal-figure figcaption').html(title);
}

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFja19pbWFnZS5hZG1pbi5pbmRleC5idW5kbGUuanMiLCJtYXBwaW5ncyI6Ijs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBLDJEQUEyRCxnQ0FBZ0M7O0FBRTNGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSIsInNvdXJjZXMiOlsid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX2ltYWdlL2FkbWluLmluZGV4LmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBDb3B5cmlnaHQgc2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIFByZXN0YVNob3AgaXMgYW4gSW50ZXJuYXRpb25hbCBSZWdpc3RlcmVkIFRyYWRlbWFyayAmIFByb3BlcnR5IG9mIFByZXN0YVNob3AgU0FcbiAqXG4gKiBOT1RJQ0UgT0YgTElDRU5TRVxuICpcbiAqIFRoaXMgc291cmNlIGZpbGUgaXMgc3ViamVjdCB0byB0aGUgQWNhZGVtaWMgRnJlZSBMaWNlbnNlIHZlcnNpb24gMy4wXG4gKiB0aGF0IGlzIGJ1bmRsZWQgd2l0aCB0aGlzIHBhY2thZ2UgaW4gdGhlIGZpbGUgTElDRU5TRS5tZC5cbiAqIEl0IGlzIGFsc28gYXZhaWxhYmxlIHRocm91Z2ggdGhlIHdvcmxkLXdpZGUtd2ViIGF0IHRoaXMgVVJMOlxuICogaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wXG4gKiBJZiB5b3UgZGlkIG5vdCByZWNlaXZlIGEgY29weSBvZiB0aGUgbGljZW5zZSBhbmQgYXJlIHVuYWJsZSB0b1xuICogb2J0YWluIGl0IHRocm91Z2ggdGhlIHdvcmxkLXdpZGUtd2ViLCBwbGVhc2Ugc2VuZCBhbiBlbWFpbFxuICogdG8gbGljZW5zZUBwcmVzdGFzaG9wLmNvbSBzbyB3ZSBjYW4gc2VuZCB5b3UgYSBjb3B5IGltbWVkaWF0ZWx5LlxuICpcbiAqIEBhdXRob3IgICAgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzIDxjb250YWN0QHByZXN0YXNob3AuY29tPlxuICogQGNvcHlyaWdodCBTaW5jZSAyMDA3IFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9yc1xuICogQGxpY2Vuc2UgICBodHRwczovL29wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL0FGTC0zLjAgQWNhZGVtaWMgRnJlZSBMaWNlbnNlIHZlcnNpb24gMy4wXG4gKi9cblxuJChmdW5jdGlvbiAoKSB7XG4gICAgJCgnI2J1eWJhY2tJbWFnZV9ncmlkX3RhYmxlIC5hZC1iYi1ncmlkLWltZycpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgbG9hZEltYWdlSW5Nb2RhbCgkKHRoaXMpLmZpbmQoJ2ltZycpLmF0dHIoJ3NyYycpKTtcbiAgICAgICAgbG9hZFRpdGxlSW5Nb2RhbCgkKHRoaXMpLmZpbmQoJ2ltZycpLmF0dHIoJ2FsdCcpKTtcbiAgICB9KTtcblxuICAgIGNvbnN0IGdyaWQgPSBuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWQoJ2J1eWJhY2tJbWFnZScpO1xuXG4gICAgZ3JpZC5hZGRFeHRlbnNpb24obmV3IHdpbmRvdy5wcmVzdGFzaG9wLmNvbXBvbmVudC5HcmlkRXh0ZW5zaW9ucy5Bc3luY1RvZ2dsZUNvbHVtbkV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkJ1bGtBY3Rpb25DaGVja2JveEV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkJ1bGtPcGVuVGFic0V4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkNob2ljZUV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkV4cG9ydFRvU3FsTWFuYWdlckV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkZpbHRlcnNSZXNldEV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLkZpbHRlcnNTdWJtaXRCdXR0b25FbmFibGVyRXh0ZW5zaW9uKCkpO1xuICAgIGdyaWQuYWRkRXh0ZW5zaW9uKG5ldyB3aW5kb3cucHJlc3Rhc2hvcC5jb21wb25lbnQuR3JpZEV4dGVuc2lvbnMuTGlua1Jvd0FjdGlvbkV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLk1vZGFsRm9ybVN1Ym1pdEV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLlBvc2l0aW9uRXh0ZW5zaW9uKCkpO1xuICAgIGdyaWQuYWRkRXh0ZW5zaW9uKG5ldyB3aW5kb3cucHJlc3Rhc2hvcC5jb21wb25lbnQuR3JpZEV4dGVuc2lvbnMuUHJldmlld0V4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLlJlbG9hZExpc3RFeHRlbnNpb24oKSk7XG4gICAgZ3JpZC5hZGRFeHRlbnNpb24obmV3IHdpbmRvdy5wcmVzdGFzaG9wLmNvbXBvbmVudC5HcmlkRXh0ZW5zaW9ucy5Tb3J0aW5nRXh0ZW5zaW9uKCkpO1xuICAgIGdyaWQuYWRkRXh0ZW5zaW9uKG5ldyB3aW5kb3cucHJlc3Rhc2hvcC5jb21wb25lbnQuR3JpZEV4dGVuc2lvbnMuU3VibWl0QnVsa0FjdGlvbkV4dGVuc2lvbigpKTtcbiAgICBncmlkLmFkZEV4dGVuc2lvbihuZXcgd2luZG93LnByZXN0YXNob3AuY29tcG9uZW50LkdyaWRFeHRlbnNpb25zLlN1Ym1pdEdyaWRBY3Rpb25FeHRlbnNpb24oKSk7XG4gICAgZ3JpZC5hZGRFeHRlbnNpb24obmV3IHdpbmRvdy5wcmVzdGFzaG9wLmNvbXBvbmVudC5HcmlkRXh0ZW5zaW9ucy5TdWJtaXRSb3dBY3Rpb25FeHRlbnNpb24oKSk7XG59KTtcblxuZnVuY3Rpb24gbG9hZEltYWdlSW5Nb2RhbChzb3VyY2UpIHtcbiAgICBsZXQgbGluayA9IHNvdXJjZS5zcGxpdCgnLycpLmZpbHRlcihmdW5jdGlvbihlbGVtZW50KSB7cmV0dXJuIGVsZW1lbnQgIT09ICd0aHVtYm5haWwnO30pLmpvaW4oJy8nKTtcblxuICAgICQoJyNidXliYWNrSW1hZ2UtZ3JpZC12aWV3LW1vZGFsJykuZmluZCgnLmFkLWJiLW1vZGFsLWZpZ3VyZSBpbWcnKS5hdHRyKCdzcmMnLCBzb3VyY2UpLmVuZCgpXG4gICAgICAgIC5maW5kKCcuYWQtYmItbW9kYWwtdmlldycpLmF0dHIoJ2hyZWYnLCBsaW5rKTtcbn1cblxuZnVuY3Rpb24gbG9hZFRpdGxlSW5Nb2RhbCh0aXRsZSkge1xuICAgICQoJyNidXliYWNrSW1hZ2UtZ3JpZC12aWV3LW1vZGFsJykuZmluZCgnLmFkLWJiLW1vZGFsLWZpZ3VyZSBpbWcnKS5hdHRyKCdhbHQnLCB0aXRsZSkuZW5kKClcbiAgICAgICAgLmZpbmQoJy5hZC1iYi1tb2RhbC1maWd1cmUgZmlnY2FwdGlvbicpLmh0bWwodGl0bGUpO1xufVxuIl0sIm5hbWVzIjpbXSwic291cmNlUm9vdCI6IiJ9