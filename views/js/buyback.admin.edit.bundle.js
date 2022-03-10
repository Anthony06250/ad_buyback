/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./buyback_image/admin.modal.js":
/*!**************************************!*\
  !*** ./buyback_image/admin.modal.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ImageModal)
/* harmony export */ });
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

class ImageModal {
    constructor(modal) {
        this.modal = $('#' + modal);
    }

    loadImageModal(trigger) {
        this.fillImageInModal($(trigger));
        this.fillTitleInModal($(trigger));
    }

    fillImageInModal(trigger) {
        let source = trigger.find('img').attr('src');
        let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');
        console.log(source);
        console.log(link);

        $('.ad-bb-modal-figure img').attr('src', source);
        $('.ad-bb-modal-view').attr('href', link);
    }

    fillTitleInModal(trigger) {
        let title = trigger.find('img').attr('alt');

        this.modal.find('.ad-bb-modal-figure img').attr('alt', title).end()
            .find('.ad-bb-modal-figure figcaption').html(title);
    }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*******************************!*\
  !*** ./buyback/admin.edit.js ***!
  \*******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _buyback_image_admin_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../buyback_image/admin.modal */ "./buyback_image/admin.modal.js");
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
    let modal = new _buyback_image_admin_modal__WEBPACK_IMPORTED_MODULE_0__["default"]('buyback-edit-view-modal');
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

})();

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFjay5hZG1pbi5lZGl0LmJ1bmRsZS5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFZTtBQUNmO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsK0RBQStELGdDQUFnQztBQUMvRjtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7O1VDN0NBO1VBQ0E7O1VBRUE7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7O1VBRUE7VUFDQTs7VUFFQTtVQUNBO1VBQ0E7Ozs7O1dDdEJBO1dBQ0E7V0FDQTtXQUNBO1dBQ0EseUNBQXlDLHdDQUF3QztXQUNqRjtXQUNBO1dBQ0E7Ozs7O1dDUEE7Ozs7O1dDQUE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7Ozs7QUNOQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRXNEOztBQUV0RDtBQUNBLG9CQUFvQixrRUFBVTtBQUM5Qjs7QUFFQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSztBQUNMLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEscUJBQXFCLDhCQUE4QjtBQUNuRDtBQUNBO0FBQ0EsaUNBQWlDLHNCQUFzQjtBQUN2RCxTQUFTO0FBQ1Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9hZC9idXliYWNrLy4vYnV5YmFja19pbWFnZS9hZG1pbi5tb2RhbC5qcyIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL2FkL2J1eWJhY2svd2VicGFjay9ydW50aW1lL2RlZmluZSBwcm9wZXJ0eSBnZXR0ZXJzIiwid2VicGFjazovL2FkL2J1eWJhY2svd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vYWQvYnV5YmFjay8uL2J1eWJhY2svYWRtaW4uZWRpdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbmV4cG9ydCBkZWZhdWx0IGNsYXNzIEltYWdlTW9kYWwge1xuICAgIGNvbnN0cnVjdG9yKG1vZGFsKSB7XG4gICAgICAgIHRoaXMubW9kYWwgPSAkKCcjJyArIG1vZGFsKTtcbiAgICB9XG5cbiAgICBsb2FkSW1hZ2VNb2RhbCh0cmlnZ2VyKSB7XG4gICAgICAgIHRoaXMuZmlsbEltYWdlSW5Nb2RhbCgkKHRyaWdnZXIpKTtcbiAgICAgICAgdGhpcy5maWxsVGl0bGVJbk1vZGFsKCQodHJpZ2dlcikpO1xuICAgIH1cblxuICAgIGZpbGxJbWFnZUluTW9kYWwodHJpZ2dlcikge1xuICAgICAgICBsZXQgc291cmNlID0gdHJpZ2dlci5maW5kKCdpbWcnKS5hdHRyKCdzcmMnKTtcbiAgICAgICAgbGV0IGxpbmsgPSBzb3VyY2Uuc3BsaXQoJy8nKS5maWx0ZXIoZnVuY3Rpb24oZWxlbWVudCkge3JldHVybiBlbGVtZW50ICE9PSAndGh1bWJuYWlsJzt9KS5qb2luKCcvJyk7XG4gICAgICAgIGNvbnNvbGUubG9nKHNvdXJjZSk7XG4gICAgICAgIGNvbnNvbGUubG9nKGxpbmspO1xuXG4gICAgICAgICQoJy5hZC1iYi1tb2RhbC1maWd1cmUgaW1nJykuYXR0cignc3JjJywgc291cmNlKTtcbiAgICAgICAgJCgnLmFkLWJiLW1vZGFsLXZpZXcnKS5hdHRyKCdocmVmJywgbGluayk7XG4gICAgfVxuXG4gICAgZmlsbFRpdGxlSW5Nb2RhbCh0cmlnZ2VyKSB7XG4gICAgICAgIGxldCB0aXRsZSA9IHRyaWdnZXIuZmluZCgnaW1nJykuYXR0cignYWx0Jyk7XG5cbiAgICAgICAgdGhpcy5tb2RhbC5maW5kKCcuYWQtYmItbW9kYWwtZmlndXJlIGltZycpLmF0dHIoJ2FsdCcsIHRpdGxlKS5lbmQoKVxuICAgICAgICAgICAgLmZpbmQoJy5hZC1iYi1tb2RhbC1maWd1cmUgZmlnY2FwdGlvbicpLmh0bWwodGl0bGUpO1xuICAgIH1cbn1cbiIsIi8vIFRoZSBtb2R1bGUgY2FjaGVcbnZhciBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX18gPSB7fTtcblxuLy8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbmZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblx0Ly8gQ2hlY2sgaWYgbW9kdWxlIGlzIGluIGNhY2hlXG5cdHZhciBjYWNoZWRNb2R1bGUgPSBfX3dlYnBhY2tfbW9kdWxlX2NhY2hlX19bbW9kdWxlSWRdO1xuXHRpZiAoY2FjaGVkTW9kdWxlICE9PSB1bmRlZmluZWQpIHtcblx0XHRyZXR1cm4gY2FjaGVkTW9kdWxlLmV4cG9ydHM7XG5cdH1cblx0Ly8gQ3JlYXRlIGEgbmV3IG1vZHVsZSAoYW5kIHB1dCBpdCBpbnRvIHRoZSBjYWNoZSlcblx0dmFyIG1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF0gPSB7XG5cdFx0Ly8gbm8gbW9kdWxlLmlkIG5lZWRlZFxuXHRcdC8vIG5vIG1vZHVsZS5sb2FkZWQgbmVlZGVkXG5cdFx0ZXhwb3J0czoge31cblx0fTtcblxuXHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cblx0X193ZWJwYWNrX21vZHVsZXNfX1ttb2R1bGVJZF0obW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cblx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcblx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xufVxuXG4iLCIvLyBkZWZpbmUgZ2V0dGVyIGZ1bmN0aW9ucyBmb3IgaGFybW9ueSBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSAoZXhwb3J0cywgZGVmaW5pdGlvbikgPT4ge1xuXHRmb3IodmFyIGtleSBpbiBkZWZpbml0aW9uKSB7XG5cdFx0aWYoX193ZWJwYWNrX3JlcXVpcmVfXy5vKGRlZmluaXRpb24sIGtleSkgJiYgIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBrZXkpKSB7XG5cdFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywga2V5LCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZGVmaW5pdGlvbltrZXldIH0pO1xuXHRcdH1cblx0fVxufTsiLCJfX3dlYnBhY2tfcmVxdWlyZV9fLm8gPSAob2JqLCBwcm9wKSA9PiAoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iaiwgcHJvcCkpIiwiLy8gZGVmaW5lIF9fZXNNb2R1bGUgb24gZXhwb3J0c1xuX193ZWJwYWNrX3JlcXVpcmVfXy5yID0gKGV4cG9ydHMpID0+IHtcblx0aWYodHlwZW9mIFN5bWJvbCAhPT0gJ3VuZGVmaW5lZCcgJiYgU3ltYm9sLnRvU3RyaW5nVGFnKSB7XG5cdFx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsIFN5bWJvbC50b1N0cmluZ1RhZywgeyB2YWx1ZTogJ01vZHVsZScgfSk7XG5cdH1cblx0T2JqZWN0LmRlZmluZVByb3BlcnR5KGV4cG9ydHMsICdfX2VzTW9kdWxlJywgeyB2YWx1ZTogdHJ1ZSB9KTtcbn07IiwiLypcbiAqIENvcHlyaWdodCBzaW5jZSAyMDA3IFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9yc1xuICogUHJlc3RhU2hvcCBpcyBhbiBJbnRlcm5hdGlvbmFsIFJlZ2lzdGVyZWQgVHJhZGVtYXJrICYgUHJvcGVydHkgb2YgUHJlc3RhU2hvcCBTQVxuICpcbiAqIE5PVElDRSBPRiBMSUNFTlNFXG4gKlxuICogVGhpcyBzb3VyY2UgZmlsZSBpcyBzdWJqZWN0IHRvIHRoZSBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqIHRoYXQgaXMgYnVuZGxlZCB3aXRoIHRoaXMgcGFja2FnZSBpbiB0aGUgZmlsZSBMSUNFTlNFLm1kLlxuICogSXQgaXMgYWxzbyBhdmFpbGFibGUgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIgYXQgdGhpcyBVUkw6XG4gKiBodHRwczovL29wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL0FGTC0zLjBcbiAqIElmIHlvdSBkaWQgbm90IHJlY2VpdmUgYSBjb3B5IG9mIHRoZSBsaWNlbnNlIGFuZCBhcmUgdW5hYmxlIHRvXG4gKiBvYnRhaW4gaXQgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIsIHBsZWFzZSBzZW5kIGFuIGVtYWlsXG4gKiB0byBsaWNlbnNlQHByZXN0YXNob3AuY29tIHNvIHdlIGNhbiBzZW5kIHlvdSBhIGNvcHkgaW1tZWRpYXRlbHkuXG4gKlxuICogQGF1dGhvciAgICBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnMgPGNvbnRhY3RAcHJlc3Rhc2hvcC5jb20+XG4gKiBAY29weXJpZ2h0IFNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBAbGljZW5zZSAgIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMCBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqL1xuXG5pbXBvcnQgSW1hZ2VNb2RhbCBmcm9tICcuLi9idXliYWNrX2ltYWdlL2FkbWluLm1vZGFsJztcblxuJChmdW5jdGlvbiAoKSB7XG4gICAgbGV0IG1vZGFsID0gbmV3IEltYWdlTW9kYWwoJ2J1eWJhY2stZWRpdC12aWV3LW1vZGFsJyk7XG4gICAgbGV0IGN1c3RvbWVySW5mb3MgPSBuZXcgQ3VzdG9tZXJJbmZvcygpO1xuXG4gICAgJCgnI2J1eV9iYWNrX2lkX2N1c3RvbWVyJykub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xuICAgICAgICBjdXN0b21lckluZm9zLmdldEN1c3RvbWVySW5mb3ModGhpcyk7XG4gICAgfSk7XG5cbiAgICAkKCcuYWQtYmItYWRtaW4taW1nLWJ0bicpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgbW9kYWwubG9hZEltYWdlTW9kYWwodGhpcyk7XG4gICAgfSk7XG59KTtcblxuY2xhc3MgQ3VzdG9tZXJJbmZvcyB7XG4gICAgY29uc3RydWN0b3IoKSB7XG4gICAgICAgIHRoaXMuZGVmYXVsdEN1c3RvbWVyID0ge1xuICAgICAgICAgICAgJ2lkX2dlbmRlcic6ICQoJyNidXlfYmFja19pZF9nZW5kZXInKS52YWwoKSxcbiAgICAgICAgICAgICdmaXJzdG5hbWUnOiAkKCcjYnV5X2JhY2tfZmlyc3RuYW1lJykudmFsKCksXG4gICAgICAgICAgICAnbGFzdG5hbWUnOiAkKCcjYnV5X2JhY2tfbGFzdG5hbWUnKS52YWwoKSxcbiAgICAgICAgICAgICdlbWFpbCc6ICQoJyNidXlfYmFja19lbWFpbCcpLnZhbCgpXG4gICAgICAgIH07XG4gICAgICAgIHRoaXMuaW5pdCgpO1xuICAgIH1cblxuICAgIGluaXQoKSB7XG4gICAgICAgIGlmICgkKCcjYnV5X2JhY2tfaWRfY3VzdG9tZXIgb3B0aW9uOnNlbGVjdGVkJykudmFsKCkpIHtcbiAgICAgICAgICAgIHRoaXMucmVhZE9ubHlJbnB1dHModHJ1ZSk7XG4gICAgICAgIH1cbiAgICB9XG5cbiAgICBnZXRDdXN0b21lckluZm9zKHRyaWdnZXIpIHtcbiAgICAgICAgbGV0IHVybCA9ICQoJyNidXlfYmFja19pZF9jdXN0b21lcicpLmF0dHIoJ2RhdGEtY3VzdG9tZXItdXJsJyk7XG4gICAgICAgIGxldCBzZWxmID0gdGhpcztcblxuICAgICAgICAkLnBvc3QodXJsLCB7J2J1eWJhY2tJZCc6ICQodHJpZ2dlcikudmFsKCl9LCBmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgICAgICAoZGF0YS5zdGF0dXMgPT09IHRydWUpXG4gICAgICAgICAgICAgICAgPyBzZWxmLmZpbGxDdXN0b21lcklucHV0cyhkYXRhLm1lc3NhZ2UpXG4gICAgICAgICAgICAgICAgOiAkLmdyb3dsLmVycm9yKHttZXNzYWdlOiBkYXRhLm1lc3NhZ2V9KTtcbiAgICAgICAgfSwgJ2pzb24nKTtcbiAgICB9XG5cbiAgICBmaWxsQ3VzdG9tZXJJbnB1dHMoZGF0YSkge1xuICAgICAgICAkKCcjYnV5X2JhY2tfaWRfZ2VuZGVyJykucHJvcCgnc2VsZWN0ZWRJbmRleCcsIGRhdGEgPyBkYXRhWydpZF9nZW5kZXInXSA6IHRoaXMuZGVmYXVsdEN1c3RvbWVyLmlkX2dlbmRlcik7XG4gICAgICAgICQoJyNidXlfYmFja19maXJzdG5hbWUnKS52YWwoZGF0YSA/IGRhdGFbJ2ZpcnN0bmFtZSddIDogdGhpcy5kZWZhdWx0Q3VzdG9tZXIuZmlyc3RuYW1lKTtcbiAgICAgICAgJCgnI2J1eV9iYWNrX2xhc3RuYW1lJykudmFsKGRhdGEgPyBkYXRhWydsYXN0bmFtZSddIDogdGhpcy5kZWZhdWx0Q3VzdG9tZXIubGFzdG5hbWUpO1xuICAgICAgICAkKCcjYnV5X2JhY2tfZW1haWwnKS52YWwoZGF0YSA/IGRhdGFbJ2VtYWlsJ10gOiB0aGlzLmRlZmF1bHRDdXN0b21lci5lbWFpbCk7XG4gICAgICAgIHRoaXMucmVhZE9ubHlJbnB1dHMoKGRhdGEpKTtcbiAgICB9XG5cbiAgICByZWFkT25seUlucHV0cyhyZWFkb25seSkge1xuICAgICAgICBsZXQgaW5wdXRJZEdlbmRlciA9ICQoJyNidXlfYmFja19pZF9nZW5kZXInKTtcblxuICAgICAgICByZWFkb25seSA/IGlucHV0SWRHZW5kZXIuYWRkQ2xhc3MoJ3JlYWRvbmx5JykgOiBpbnB1dElkR2VuZGVyLnJlbW92ZUNsYXNzKCdyZWFkb25seScpXG4gICAgICAgICQoJyNidXlfYmFja19maXJzdG5hbWUnKS5hdHRyKCdyZWFkb25seScsIHJlYWRvbmx5KTtcbiAgICAgICAgJCgnI2J1eV9iYWNrX2xhc3RuYW1lJykuYXR0cigncmVhZG9ubHknLCByZWFkb25seSk7XG4gICAgICAgICQoJyNidXlfYmFja19lbWFpbCcpLmF0dHIoJ3JlYWRvbmx5JywgcmVhZG9ubHkpO1xuICAgIH1cbn1cbiJdLCJuYW1lcyI6W10sInNvdXJjZVJvb3QiOiIifQ==