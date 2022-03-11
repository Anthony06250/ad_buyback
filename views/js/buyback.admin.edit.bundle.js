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
        this.modal.modal('show');
    }

    fillImageInModal(trigger) {
        let source = trigger.find('img').attr('src');
        let link = source.split('/').filter(function(element) {return element !== 'thumbnail';}).join('/');
        let button = $('.ad-bb-modal-view');

        $('.ad-bb-modal-figure img').attr('src', source);
        (source.split(':')[0] !== 'data')
            ? button.attr('href', link).removeClass('hidden')
            : button.attr('href', '').addClass('hidden');
    }

    fillTitleInModal(trigger) {
        let title = trigger.find('img').attr('alt');

        this.modal.find('.ad-bb-modal-figure img').attr('alt', title).end()
            .find('.ad-bb-modal-figure figcaption').html(title);
    }
}


/***/ }),

/***/ "./buyback_image/image.preview.js":
/*!****************************************!*\
  !*** ./buyback_image/image.preview.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ ImagePreview)
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

class ImagePreview {
    constructor(preview) {
        this.preview = $('#' + preview);
    }

    init(trigger) {
        let self = this;

        if (trigger.files && trigger.files[0]) {
            this.preview.removeClass('hidden').find('.ad-bb-img-preview-content').slice(1).remove();
            $.each(trigger.files, function (key, file) {
                self.previewImage(file);
            });
        }
    }

    previewImage(file) {
        let reader = new FileReader();
        let self = this;

        reader.onload = function (event) {
            let clone = self.preview.find('.ad-bb-img-preview-content:first').clone().removeClass('hidden');

            $(clone).find('img').attr('src', event.target.result).attr('alt', file.name).end()
                .find('.ad-bb-img-preview-title').html(self.formatFilename(file.name));

            self.preview.find('section').append(clone);
        };

        reader.readAsDataURL(file);
    }

    formatFilename(filename) {
        let name = filename.split('.').slice(0, -1).join('.');

        if (name.length > 23) {
            return name.slice(0, 15) + '...';
        }

        return name;
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
/* harmony import */ var _buyback_image_image_preview__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../buyback_image/image.preview */ "./buyback_image/image.preview.js");
/* harmony import */ var _buyback_image_admin_modal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../buyback_image/admin.modal */ "./buyback_image/admin.modal.js");
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
    let imagePreview = new _buyback_image_image_preview__WEBPACK_IMPORTED_MODULE_0__["default"]('buyback-form-img-preview');
    let modal = new _buyback_image_admin_modal__WEBPACK_IMPORTED_MODULE_1__["default"]('buyback-form-view-modal');

    $('#buy_back_id_customer').on('change', function() {
        customerInfos.getCustomerInfos(this);
    });

    $('#buy_back_image').on('change', function() {
        imagePreview.init(this);
    });

    $('body').on('click', '.ad-bb-img-preview-btn', function() {
        modal.loadImageModal(this);
    }).on('mouseover', '.ad-bb-img-preview-btn img', function() {
        $(this).pstooltip('show');
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

        readonly
            ? inputIdGender.addClass('readonly')
            : inputIdGender.removeClass('readonly')
        $('#buy_back_firstname').attr('readonly', readonly);
        $('#buy_back_lastname').attr('readonly', readonly);
        $('#buy_back_email').attr('readonly', readonly);
    }
}

})();

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFjay5hZG1pbi5lZGl0LmJ1bmRsZS5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFZTtBQUNmO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSwrREFBK0QsZ0NBQWdDO0FBQy9GOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7Ozs7O0FDL0NBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFZTtBQUNmO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYTtBQUNiO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOzs7Ozs7O1VDNURBO1VBQ0E7O1VBRUE7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7O1VBRUE7VUFDQTs7VUFFQTtVQUNBO1VBQ0E7Ozs7O1dDdEJBO1dBQ0E7V0FDQTtXQUNBO1dBQ0EseUNBQXlDLHdDQUF3QztXQUNqRjtXQUNBO1dBQ0E7Ozs7O1dDUEE7Ozs7O1dDQUE7V0FDQTtXQUNBO1dBQ0EsdURBQXVELGlCQUFpQjtXQUN4RTtXQUNBLGdEQUFnRCxhQUFhO1dBQzdEOzs7Ozs7Ozs7Ozs7O0FDTkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUUwRDtBQUNKOztBQUV0RDtBQUNBO0FBQ0EsMkJBQTJCLG9FQUFZO0FBQ3ZDLG9CQUFvQixrRUFBVTs7QUFFOUI7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBLEtBQUs7QUFDTCxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLHFCQUFxQiw4QkFBOEI7QUFDbkQ7QUFDQTtBQUNBLGlDQUFpQyxzQkFBc0I7QUFDdkQsU0FBUztBQUNUOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSIsInNvdXJjZXMiOlsid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX2ltYWdlL2FkbWluLm1vZGFsLmpzIiwid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrX2ltYWdlL2ltYWdlLnByZXZpZXcuanMiLCJ3ZWJwYWNrOi8vYWQvYnV5YmFjay93ZWJwYWNrL2Jvb3RzdHJhcCIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svcnVudGltZS9kZWZpbmUgcHJvcGVydHkgZ2V0dGVycyIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svcnVudGltZS9oYXNPd25Qcm9wZXJ0eSBzaG9ydGhhbmQiLCJ3ZWJwYWNrOi8vYWQvYnV5YmFjay93ZWJwYWNrL3J1bnRpbWUvbWFrZSBuYW1lc3BhY2Ugb2JqZWN0Iiwid2VicGFjazovL2FkL2J1eWJhY2svLi9idXliYWNrL2FkbWluLmVkaXQuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLypcbiAqIENvcHlyaWdodCBzaW5jZSAyMDA3IFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9yc1xuICogUHJlc3RhU2hvcCBpcyBhbiBJbnRlcm5hdGlvbmFsIFJlZ2lzdGVyZWQgVHJhZGVtYXJrICYgUHJvcGVydHkgb2YgUHJlc3RhU2hvcCBTQVxuICpcbiAqIE5PVElDRSBPRiBMSUNFTlNFXG4gKlxuICogVGhpcyBzb3VyY2UgZmlsZSBpcyBzdWJqZWN0IHRvIHRoZSBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqIHRoYXQgaXMgYnVuZGxlZCB3aXRoIHRoaXMgcGFja2FnZSBpbiB0aGUgZmlsZSBMSUNFTlNFLm1kLlxuICogSXQgaXMgYWxzbyBhdmFpbGFibGUgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIgYXQgdGhpcyBVUkw6XG4gKiBodHRwczovL29wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL0FGTC0zLjBcbiAqIElmIHlvdSBkaWQgbm90IHJlY2VpdmUgYSBjb3B5IG9mIHRoZSBsaWNlbnNlIGFuZCBhcmUgdW5hYmxlIHRvXG4gKiBvYnRhaW4gaXQgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIsIHBsZWFzZSBzZW5kIGFuIGVtYWlsXG4gKiB0byBsaWNlbnNlQHByZXN0YXNob3AuY29tIHNvIHdlIGNhbiBzZW5kIHlvdSBhIGNvcHkgaW1tZWRpYXRlbHkuXG4gKlxuICogQGF1dGhvciAgICBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnMgPGNvbnRhY3RAcHJlc3Rhc2hvcC5jb20+XG4gKiBAY29weXJpZ2h0IFNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBAbGljZW5zZSAgIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMCBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqL1xuXG5leHBvcnQgZGVmYXVsdCBjbGFzcyBJbWFnZU1vZGFsIHtcbiAgICBjb25zdHJ1Y3Rvcihtb2RhbCkge1xuICAgICAgICB0aGlzLm1vZGFsID0gJCgnIycgKyBtb2RhbCk7XG4gICAgfVxuXG4gICAgbG9hZEltYWdlTW9kYWwodHJpZ2dlcikge1xuICAgICAgICB0aGlzLmZpbGxJbWFnZUluTW9kYWwoJCh0cmlnZ2VyKSk7XG4gICAgICAgIHRoaXMuZmlsbFRpdGxlSW5Nb2RhbCgkKHRyaWdnZXIpKTtcbiAgICAgICAgdGhpcy5tb2RhbC5tb2RhbCgnc2hvdycpO1xuICAgIH1cblxuICAgIGZpbGxJbWFnZUluTW9kYWwodHJpZ2dlcikge1xuICAgICAgICBsZXQgc291cmNlID0gdHJpZ2dlci5maW5kKCdpbWcnKS5hdHRyKCdzcmMnKTtcbiAgICAgICAgbGV0IGxpbmsgPSBzb3VyY2Uuc3BsaXQoJy8nKS5maWx0ZXIoZnVuY3Rpb24oZWxlbWVudCkge3JldHVybiBlbGVtZW50ICE9PSAndGh1bWJuYWlsJzt9KS5qb2luKCcvJyk7XG4gICAgICAgIGxldCBidXR0b24gPSAkKCcuYWQtYmItbW9kYWwtdmlldycpO1xuXG4gICAgICAgICQoJy5hZC1iYi1tb2RhbC1maWd1cmUgaW1nJykuYXR0cignc3JjJywgc291cmNlKTtcbiAgICAgICAgKHNvdXJjZS5zcGxpdCgnOicpWzBdICE9PSAnZGF0YScpXG4gICAgICAgICAgICA/IGJ1dHRvbi5hdHRyKCdocmVmJywgbGluaykucmVtb3ZlQ2xhc3MoJ2hpZGRlbicpXG4gICAgICAgICAgICA6IGJ1dHRvbi5hdHRyKCdocmVmJywgJycpLmFkZENsYXNzKCdoaWRkZW4nKTtcbiAgICB9XG5cbiAgICBmaWxsVGl0bGVJbk1vZGFsKHRyaWdnZXIpIHtcbiAgICAgICAgbGV0IHRpdGxlID0gdHJpZ2dlci5maW5kKCdpbWcnKS5hdHRyKCdhbHQnKTtcblxuICAgICAgICB0aGlzLm1vZGFsLmZpbmQoJy5hZC1iYi1tb2RhbC1maWd1cmUgaW1nJykuYXR0cignYWx0JywgdGl0bGUpLmVuZCgpXG4gICAgICAgICAgICAuZmluZCgnLmFkLWJiLW1vZGFsLWZpZ3VyZSBmaWdjYXB0aW9uJykuaHRtbCh0aXRsZSk7XG4gICAgfVxufVxuIiwiLypcbiAqIENvcHlyaWdodCBzaW5jZSAyMDA3IFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9yc1xuICogUHJlc3RhU2hvcCBpcyBhbiBJbnRlcm5hdGlvbmFsIFJlZ2lzdGVyZWQgVHJhZGVtYXJrICYgUHJvcGVydHkgb2YgUHJlc3RhU2hvcCBTQVxuICpcbiAqIE5PVElDRSBPRiBMSUNFTlNFXG4gKlxuICogVGhpcyBzb3VyY2UgZmlsZSBpcyBzdWJqZWN0IHRvIHRoZSBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqIHRoYXQgaXMgYnVuZGxlZCB3aXRoIHRoaXMgcGFja2FnZSBpbiB0aGUgZmlsZSBMSUNFTlNFLm1kLlxuICogSXQgaXMgYWxzbyBhdmFpbGFibGUgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIgYXQgdGhpcyBVUkw6XG4gKiBodHRwczovL29wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL0FGTC0zLjBcbiAqIElmIHlvdSBkaWQgbm90IHJlY2VpdmUgYSBjb3B5IG9mIHRoZSBsaWNlbnNlIGFuZCBhcmUgdW5hYmxlIHRvXG4gKiBvYnRhaW4gaXQgdGhyb3VnaCB0aGUgd29ybGQtd2lkZS13ZWIsIHBsZWFzZSBzZW5kIGFuIGVtYWlsXG4gKiB0byBsaWNlbnNlQHByZXN0YXNob3AuY29tIHNvIHdlIGNhbiBzZW5kIHlvdSBhIGNvcHkgaW1tZWRpYXRlbHkuXG4gKlxuICogQGF1dGhvciAgICBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnMgPGNvbnRhY3RAcHJlc3Rhc2hvcC5jb20+XG4gKiBAY29weXJpZ2h0IFNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBAbGljZW5zZSAgIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMCBBY2FkZW1pYyBGcmVlIExpY2Vuc2UgdmVyc2lvbiAzLjBcbiAqL1xuXG5leHBvcnQgZGVmYXVsdCBjbGFzcyBJbWFnZVByZXZpZXcge1xuICAgIGNvbnN0cnVjdG9yKHByZXZpZXcpIHtcbiAgICAgICAgdGhpcy5wcmV2aWV3ID0gJCgnIycgKyBwcmV2aWV3KTtcbiAgICB9XG5cbiAgICBpbml0KHRyaWdnZXIpIHtcbiAgICAgICAgbGV0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIGlmICh0cmlnZ2VyLmZpbGVzICYmIHRyaWdnZXIuZmlsZXNbMF0pIHtcbiAgICAgICAgICAgIHRoaXMucHJldmlldy5yZW1vdmVDbGFzcygnaGlkZGVuJykuZmluZCgnLmFkLWJiLWltZy1wcmV2aWV3LWNvbnRlbnQnKS5zbGljZSgxKS5yZW1vdmUoKTtcbiAgICAgICAgICAgICQuZWFjaCh0cmlnZ2VyLmZpbGVzLCBmdW5jdGlvbiAoa2V5LCBmaWxlKSB7XG4gICAgICAgICAgICAgICAgc2VsZi5wcmV2aWV3SW1hZ2UoZmlsZSk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHByZXZpZXdJbWFnZShmaWxlKSB7XG4gICAgICAgIGxldCByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuICAgICAgICBsZXQgc2VsZiA9IHRoaXM7XG5cbiAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uIChldmVudCkge1xuICAgICAgICAgICAgbGV0IGNsb25lID0gc2VsZi5wcmV2aWV3LmZpbmQoJy5hZC1iYi1pbWctcHJldmlldy1jb250ZW50OmZpcnN0JykuY2xvbmUoKS5yZW1vdmVDbGFzcygnaGlkZGVuJyk7XG5cbiAgICAgICAgICAgICQoY2xvbmUpLmZpbmQoJ2ltZycpLmF0dHIoJ3NyYycsIGV2ZW50LnRhcmdldC5yZXN1bHQpLmF0dHIoJ2FsdCcsIGZpbGUubmFtZSkuZW5kKClcbiAgICAgICAgICAgICAgICAuZmluZCgnLmFkLWJiLWltZy1wcmV2aWV3LXRpdGxlJykuaHRtbChzZWxmLmZvcm1hdEZpbGVuYW1lKGZpbGUubmFtZSkpO1xuXG4gICAgICAgICAgICBzZWxmLnByZXZpZXcuZmluZCgnc2VjdGlvbicpLmFwcGVuZChjbG9uZSk7XG4gICAgICAgIH07XG5cbiAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoZmlsZSk7XG4gICAgfVxuXG4gICAgZm9ybWF0RmlsZW5hbWUoZmlsZW5hbWUpIHtcbiAgICAgICAgbGV0IG5hbWUgPSBmaWxlbmFtZS5zcGxpdCgnLicpLnNsaWNlKDAsIC0xKS5qb2luKCcuJyk7XG5cbiAgICAgICAgaWYgKG5hbWUubGVuZ3RoID4gMjMpIHtcbiAgICAgICAgICAgIHJldHVybiBuYW1lLnNsaWNlKDAsIDE1KSArICcuLi4nO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIG5hbWU7XG4gICAgfVxufVxuIiwiLy8gVGhlIG1vZHVsZSBjYWNoZVxudmFyIF9fd2VicGFja19tb2R1bGVfY2FjaGVfXyA9IHt9O1xuXG4vLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcblx0dmFyIGNhY2hlZE1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF07XG5cdGlmIChjYWNoZWRNb2R1bGUgIT09IHVuZGVmaW5lZCkge1xuXHRcdHJldHVybiBjYWNoZWRNb2R1bGUuZXhwb3J0cztcblx0fVxuXHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuXHR2YXIgbW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXSA9IHtcblx0XHQvLyBubyBtb2R1bGUuaWQgbmVlZGVkXG5cdFx0Ly8gbm8gbW9kdWxlLmxvYWRlZCBuZWVkZWRcblx0XHRleHBvcnRzOiB7fVxuXHR9O1xuXG5cdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuXHRfX3dlYnBhY2tfbW9kdWxlc19fW21vZHVsZUlkXShtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuXHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuXHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG59XG5cbiIsIi8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb25zIGZvciBoYXJtb255IGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uZCA9IChleHBvcnRzLCBkZWZpbml0aW9uKSA9PiB7XG5cdGZvcih2YXIga2V5IGluIGRlZmluaXRpb24pIHtcblx0XHRpZihfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZGVmaW5pdGlvbiwga2V5KSAmJiAhX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIGtleSkpIHtcblx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBrZXksIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBkZWZpbml0aW9uW2tleV0gfSk7XG5cdFx0fVxuXHR9XG59OyIsIl9fd2VicGFja19yZXF1aXJlX18ubyA9IChvYmosIHByb3ApID0+IChPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkiLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbmltcG9ydCBJbWFnZVByZXZpZXcgZnJvbSAnLi4vYnV5YmFja19pbWFnZS9pbWFnZS5wcmV2aWV3JztcbmltcG9ydCBJbWFnZU1vZGFsIGZyb20gJy4uL2J1eWJhY2tfaW1hZ2UvYWRtaW4ubW9kYWwnO1xuXG4kKGZ1bmN0aW9uICgpIHtcbiAgICBsZXQgY3VzdG9tZXJJbmZvcyA9IG5ldyBDdXN0b21lckluZm9zKCk7XG4gICAgbGV0IGltYWdlUHJldmlldyA9IG5ldyBJbWFnZVByZXZpZXcoJ2J1eWJhY2stZm9ybS1pbWctcHJldmlldycpO1xuICAgIGxldCBtb2RhbCA9IG5ldyBJbWFnZU1vZGFsKCdidXliYWNrLWZvcm0tdmlldy1tb2RhbCcpO1xuXG4gICAgJCgnI2J1eV9iYWNrX2lkX2N1c3RvbWVyJykub24oJ2NoYW5nZScsIGZ1bmN0aW9uKCkge1xuICAgICAgICBjdXN0b21lckluZm9zLmdldEN1c3RvbWVySW5mb3ModGhpcyk7XG4gICAgfSk7XG5cbiAgICAkKCcjYnV5X2JhY2tfaW1hZ2UnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGltYWdlUHJldmlldy5pbml0KHRoaXMpO1xuICAgIH0pO1xuXG4gICAgJCgnYm9keScpLm9uKCdjbGljaycsICcuYWQtYmItaW1nLXByZXZpZXctYnRuJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIG1vZGFsLmxvYWRJbWFnZU1vZGFsKHRoaXMpO1xuICAgIH0pLm9uKCdtb3VzZW92ZXInLCAnLmFkLWJiLWltZy1wcmV2aWV3LWJ0biBpbWcnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgJCh0aGlzKS5wc3Rvb2x0aXAoJ3Nob3cnKTtcbiAgICB9KTtcbn0pO1xuXG5jbGFzcyBDdXN0b21lckluZm9zIHtcbiAgICBjb25zdHJ1Y3RvcigpIHtcbiAgICAgICAgdGhpcy5kZWZhdWx0Q3VzdG9tZXIgPSB7XG4gICAgICAgICAgICAnaWRfZ2VuZGVyJzogJCgnI2J1eV9iYWNrX2lkX2dlbmRlcicpLnZhbCgpLFxuICAgICAgICAgICAgJ2ZpcnN0bmFtZSc6ICQoJyNidXlfYmFja19maXJzdG5hbWUnKS52YWwoKSxcbiAgICAgICAgICAgICdsYXN0bmFtZSc6ICQoJyNidXlfYmFja19sYXN0bmFtZScpLnZhbCgpLFxuICAgICAgICAgICAgJ2VtYWlsJzogJCgnI2J1eV9iYWNrX2VtYWlsJykudmFsKClcbiAgICAgICAgfTtcbiAgICAgICAgdGhpcy5pbml0KCk7XG4gICAgfVxuXG4gICAgaW5pdCgpIHtcbiAgICAgICAgaWYgKCQoJyNidXlfYmFja19pZF9jdXN0b21lciBvcHRpb246c2VsZWN0ZWQnKS52YWwoKSkge1xuICAgICAgICAgICAgdGhpcy5yZWFkT25seUlucHV0cyh0cnVlKTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIGdldEN1c3RvbWVySW5mb3ModHJpZ2dlcikge1xuICAgICAgICBsZXQgdXJsID0gJCgnI2J1eV9iYWNrX2lkX2N1c3RvbWVyJykuYXR0cignZGF0YS1jdXN0b21lci11cmwnKTtcbiAgICAgICAgbGV0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgICQucG9zdCh1cmwsIHsnYnV5YmFja0lkJzogJCh0cmlnZ2VyKS52YWwoKX0sIGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgICAgICAgIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSlcbiAgICAgICAgICAgICAgICA/IHNlbGYuZmlsbEN1c3RvbWVySW5wdXRzKGRhdGEubWVzc2FnZSlcbiAgICAgICAgICAgICAgICA6ICQuZ3Jvd2wuZXJyb3Ioe21lc3NhZ2U6IGRhdGEubWVzc2FnZX0pO1xuICAgICAgICB9LCAnanNvbicpO1xuICAgIH1cblxuICAgIGZpbGxDdXN0b21lcklucHV0cyhkYXRhKSB7XG4gICAgICAgICQoJyNidXlfYmFja19pZF9nZW5kZXInKS5wcm9wKCdzZWxlY3RlZEluZGV4JywgZGF0YSA/IGRhdGFbJ2lkX2dlbmRlciddIDogdGhpcy5kZWZhdWx0Q3VzdG9tZXIuaWRfZ2VuZGVyKTtcbiAgICAgICAgJCgnI2J1eV9iYWNrX2ZpcnN0bmFtZScpLnZhbChkYXRhID8gZGF0YVsnZmlyc3RuYW1lJ10gOiB0aGlzLmRlZmF1bHRDdXN0b21lci5maXJzdG5hbWUpO1xuICAgICAgICAkKCcjYnV5X2JhY2tfbGFzdG5hbWUnKS52YWwoZGF0YSA/IGRhdGFbJ2xhc3RuYW1lJ10gOiB0aGlzLmRlZmF1bHRDdXN0b21lci5sYXN0bmFtZSk7XG4gICAgICAgICQoJyNidXlfYmFja19lbWFpbCcpLnZhbChkYXRhID8gZGF0YVsnZW1haWwnXSA6IHRoaXMuZGVmYXVsdEN1c3RvbWVyLmVtYWlsKTtcbiAgICAgICAgdGhpcy5yZWFkT25seUlucHV0cygoZGF0YSkpO1xuICAgIH1cblxuICAgIHJlYWRPbmx5SW5wdXRzKHJlYWRvbmx5KSB7XG4gICAgICAgIGxldCBpbnB1dElkR2VuZGVyID0gJCgnI2J1eV9iYWNrX2lkX2dlbmRlcicpO1xuXG4gICAgICAgIHJlYWRvbmx5XG4gICAgICAgICAgICA/IGlucHV0SWRHZW5kZXIuYWRkQ2xhc3MoJ3JlYWRvbmx5JylcbiAgICAgICAgICAgIDogaW5wdXRJZEdlbmRlci5yZW1vdmVDbGFzcygncmVhZG9ubHknKVxuICAgICAgICAkKCcjYnV5X2JhY2tfZmlyc3RuYW1lJykuYXR0cigncmVhZG9ubHknLCByZWFkb25seSk7XG4gICAgICAgICQoJyNidXlfYmFja19sYXN0bmFtZScpLmF0dHIoJ3JlYWRvbmx5JywgcmVhZG9ubHkpO1xuICAgICAgICAkKCcjYnV5X2JhY2tfZW1haWwnKS5hdHRyKCdyZWFkb25seScsIHJlYWRvbmx5KTtcbiAgICB9XG59XG4iXSwibmFtZXMiOltdLCJzb3VyY2VSb290IjoiIn0=