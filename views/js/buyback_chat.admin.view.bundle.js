/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./buyback/admin.modal.js":
/*!********************************!*\
  !*** ./buyback/admin.modal.js ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Modal)
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

class Modal {
    constructor(modal) {
        this.modal = $('#' + modal);
        this.trigger = null;
        this.init();
    }

    init() {
        let self = this;

        this.modal.find('.btn-confirm-submit').on('click', function () {
            self.submitForm();
        });
    }

    show(trigger) {
        this.trigger = $(trigger);
        this.fillModal();
        this.modal.modal('show');
    }

    fillModal() {
        this.modal.find('.modal-title').html(this.trigger.attr('data-title'));
        this.modal.find('.confirm-message').text(this.trigger.attr('data-confirm-message'));
        this.modal.find('.modal-footer button:first').text(this.trigger.attr('data-close-button-label'));
        this.modal.find('.btn-confirm-submit').text(this.trigger.attr('data-confirm-button-label'))
            .removeClass('btn-success', 'btn-danger', 'btn-warning', 'btn-info', 'btn-primary', 'btn-secondary')
            .addClass(this.trigger.attr('data-confirm-button-class') ?? 'btn-primary');
    }

    submitForm() {
        $('<form>').attr('action', this.trigger.attr('data-url')).attr('method', 'POST')
            .appendTo('body').submit();
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
/*!************************************!*\
  !*** ./buyback_chat/admin.view.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _buyback_admin_modal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../buyback/admin.modal */ "./buyback/admin.modal.js");
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
    let modal = new _buyback_admin_modal__WEBPACK_IMPORTED_MODULE_0__["default"]('buyback-chat-modal');
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

})();

/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFja19jaGF0LmFkbWluLnZpZXcuYnVuZGxlLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVlO0FBQ2Y7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7VUNyREE7VUFDQTs7VUFFQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTtVQUNBO1VBQ0E7VUFDQTs7VUFFQTtVQUNBOztVQUVBO1VBQ0E7VUFDQTs7Ozs7V0N0QkE7V0FDQTtXQUNBO1dBQ0E7V0FDQSx5Q0FBeUMsd0NBQXdDO1dBQ2pGO1dBQ0E7V0FDQTs7Ozs7V0NQQTs7Ozs7V0NBQTtXQUNBO1dBQ0E7V0FDQSx1REFBdUQsaUJBQWlCO1dBQ3hFO1dBQ0EsZ0RBQWdELGFBQWE7V0FDN0Q7Ozs7Ozs7Ozs7OztBQ05BO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFMkM7O0FBRTNDO0FBQ0Esb0JBQW9CLDREQUFLO0FBQ3pCO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLO0FBQ0wsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EseUJBQXlCLHNCQUFzQjtBQUMvQztBQUNBLGNBQWM7QUFDZCwrQkFBK0Isc0JBQXNCO0FBQ3JEO0FBQ0EsU0FBUztBQUNUOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSwyQkFBMkIsc0JBQXNCO0FBQ2pELGlDQUFpQyxzQkFBc0I7QUFDdkQsU0FBUztBQUNUO0FBQ0EiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly9hZC9idXliYWNrLy4vYnV5YmFjay9hZG1pbi5tb2RhbC5qcyIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svYm9vdHN0cmFwIiwid2VicGFjazovL2FkL2J1eWJhY2svd2VicGFjay9ydW50aW1lL2RlZmluZSBwcm9wZXJ0eSBnZXR0ZXJzIiwid2VicGFjazovL2FkL2J1eWJhY2svd2VicGFjay9ydW50aW1lL2hhc093blByb3BlcnR5IHNob3J0aGFuZCIsIndlYnBhY2s6Ly9hZC9idXliYWNrL3dlYnBhY2svcnVudGltZS9tYWtlIG5hbWVzcGFjZSBvYmplY3QiLCJ3ZWJwYWNrOi8vYWQvYnV5YmFjay8uL2J1eWJhY2tfY2hhdC9hZG1pbi52aWV3LmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBDb3B5cmlnaHQgc2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIFByZXN0YVNob3AgaXMgYW4gSW50ZXJuYXRpb25hbCBSZWdpc3RlcmVkIFRyYWRlbWFyayAmIFByb3BlcnR5IG9mIFByZXN0YVNob3AgU0FcbiAqXG4gKiBOT1RJQ0UgT0YgTElDRU5TRVxuICpcbiAqIFRoaXMgc291cmNlIGZpbGUgaXMgc3ViamVjdCB0byB0aGUgQWNhZGVtaWMgRnJlZSBMaWNlbnNlIHZlcnNpb24gMy4wXG4gKiB0aGF0IGlzIGJ1bmRsZWQgd2l0aCB0aGlzIHBhY2thZ2UgaW4gdGhlIGZpbGUgTElDRU5TRS5tZC5cbiAqIEl0IGlzIGFsc28gYXZhaWxhYmxlIHRocm91Z2ggdGhlIHdvcmxkLXdpZGUtd2ViIGF0IHRoaXMgVVJMOlxuICogaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wXG4gKiBJZiB5b3UgZGlkIG5vdCByZWNlaXZlIGEgY29weSBvZiB0aGUgbGljZW5zZSBhbmQgYXJlIHVuYWJsZSB0b1xuICogb2J0YWluIGl0IHRocm91Z2ggdGhlIHdvcmxkLXdpZGUtd2ViLCBwbGVhc2Ugc2VuZCBhbiBlbWFpbFxuICogdG8gbGljZW5zZUBwcmVzdGFzaG9wLmNvbSBzbyB3ZSBjYW4gc2VuZCB5b3UgYSBjb3B5IGltbWVkaWF0ZWx5LlxuICpcbiAqIEBhdXRob3IgICAgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzIDxjb250YWN0QHByZXN0YXNob3AuY29tPlxuICogQGNvcHlyaWdodCBTaW5jZSAyMDA3IFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9yc1xuICogQGxpY2Vuc2UgICBodHRwczovL29wZW5zb3VyY2Uub3JnL2xpY2Vuc2VzL0FGTC0zLjAgQWNhZGVtaWMgRnJlZSBMaWNlbnNlIHZlcnNpb24gMy4wXG4gKi9cblxuZXhwb3J0IGRlZmF1bHQgY2xhc3MgTW9kYWwge1xuICAgIGNvbnN0cnVjdG9yKG1vZGFsKSB7XG4gICAgICAgIHRoaXMubW9kYWwgPSAkKCcjJyArIG1vZGFsKTtcbiAgICAgICAgdGhpcy50cmlnZ2VyID0gbnVsbDtcbiAgICAgICAgdGhpcy5pbml0KCk7XG4gICAgfVxuXG4gICAgaW5pdCgpIHtcbiAgICAgICAgbGV0IHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIHRoaXMubW9kYWwuZmluZCgnLmJ0bi1jb25maXJtLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICAgIHNlbGYuc3VibWl0Rm9ybSgpO1xuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICBzaG93KHRyaWdnZXIpIHtcbiAgICAgICAgdGhpcy50cmlnZ2VyID0gJCh0cmlnZ2VyKTtcbiAgICAgICAgdGhpcy5maWxsTW9kYWwoKTtcbiAgICAgICAgdGhpcy5tb2RhbC5tb2RhbCgnc2hvdycpO1xuICAgIH1cblxuICAgIGZpbGxNb2RhbCgpIHtcbiAgICAgICAgdGhpcy5tb2RhbC5maW5kKCcubW9kYWwtdGl0bGUnKS5odG1sKHRoaXMudHJpZ2dlci5hdHRyKCdkYXRhLXRpdGxlJykpO1xuICAgICAgICB0aGlzLm1vZGFsLmZpbmQoJy5jb25maXJtLW1lc3NhZ2UnKS50ZXh0KHRoaXMudHJpZ2dlci5hdHRyKCdkYXRhLWNvbmZpcm0tbWVzc2FnZScpKTtcbiAgICAgICAgdGhpcy5tb2RhbC5maW5kKCcubW9kYWwtZm9vdGVyIGJ1dHRvbjpmaXJzdCcpLnRleHQodGhpcy50cmlnZ2VyLmF0dHIoJ2RhdGEtY2xvc2UtYnV0dG9uLWxhYmVsJykpO1xuICAgICAgICB0aGlzLm1vZGFsLmZpbmQoJy5idG4tY29uZmlybS1zdWJtaXQnKS50ZXh0KHRoaXMudHJpZ2dlci5hdHRyKCdkYXRhLWNvbmZpcm0tYnV0dG9uLWxhYmVsJykpXG4gICAgICAgICAgICAucmVtb3ZlQ2xhc3MoJ2J0bi1zdWNjZXNzJywgJ2J0bi1kYW5nZXInLCAnYnRuLXdhcm5pbmcnLCAnYnRuLWluZm8nLCAnYnRuLXByaW1hcnknLCAnYnRuLXNlY29uZGFyeScpXG4gICAgICAgICAgICAuYWRkQ2xhc3ModGhpcy50cmlnZ2VyLmF0dHIoJ2RhdGEtY29uZmlybS1idXR0b24tY2xhc3MnKSA/PyAnYnRuLXByaW1hcnknKTtcbiAgICB9XG5cbiAgICBzdWJtaXRGb3JtKCkge1xuICAgICAgICAkKCc8Zm9ybT4nKS5hdHRyKCdhY3Rpb24nLCB0aGlzLnRyaWdnZXIuYXR0cignZGF0YS11cmwnKSkuYXR0cignbWV0aG9kJywgJ1BPU1QnKVxuICAgICAgICAgICAgLmFwcGVuZFRvKCdib2R5Jykuc3VibWl0KCk7XG4gICAgfVxufVxuIiwiLy8gVGhlIG1vZHVsZSBjYWNoZVxudmFyIF9fd2VicGFja19tb2R1bGVfY2FjaGVfXyA9IHt9O1xuXG4vLyBUaGUgcmVxdWlyZSBmdW5jdGlvblxuZnVuY3Rpb24gX193ZWJwYWNrX3JlcXVpcmVfXyhtb2R1bGVJZCkge1xuXHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcblx0dmFyIGNhY2hlZE1vZHVsZSA9IF9fd2VicGFja19tb2R1bGVfY2FjaGVfX1ttb2R1bGVJZF07XG5cdGlmIChjYWNoZWRNb2R1bGUgIT09IHVuZGVmaW5lZCkge1xuXHRcdHJldHVybiBjYWNoZWRNb2R1bGUuZXhwb3J0cztcblx0fVxuXHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuXHR2YXIgbW9kdWxlID0gX193ZWJwYWNrX21vZHVsZV9jYWNoZV9fW21vZHVsZUlkXSA9IHtcblx0XHQvLyBubyBtb2R1bGUuaWQgbmVlZGVkXG5cdFx0Ly8gbm8gbW9kdWxlLmxvYWRlZCBuZWVkZWRcblx0XHRleHBvcnRzOiB7fVxuXHR9O1xuXG5cdC8vIEV4ZWN1dGUgdGhlIG1vZHVsZSBmdW5jdGlvblxuXHRfX3dlYnBhY2tfbW9kdWxlc19fW21vZHVsZUlkXShtb2R1bGUsIG1vZHVsZS5leHBvcnRzLCBfX3dlYnBhY2tfcmVxdWlyZV9fKTtcblxuXHQvLyBSZXR1cm4gdGhlIGV4cG9ydHMgb2YgdGhlIG1vZHVsZVxuXHRyZXR1cm4gbW9kdWxlLmV4cG9ydHM7XG59XG5cbiIsIi8vIGRlZmluZSBnZXR0ZXIgZnVuY3Rpb25zIGZvciBoYXJtb255IGV4cG9ydHNcbl9fd2VicGFja19yZXF1aXJlX18uZCA9IChleHBvcnRzLCBkZWZpbml0aW9uKSA9PiB7XG5cdGZvcih2YXIga2V5IGluIGRlZmluaXRpb24pIHtcblx0XHRpZihfX3dlYnBhY2tfcmVxdWlyZV9fLm8oZGVmaW5pdGlvbiwga2V5KSAmJiAhX193ZWJwYWNrX3JlcXVpcmVfXy5vKGV4cG9ydHMsIGtleSkpIHtcblx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBrZXksIHsgZW51bWVyYWJsZTogdHJ1ZSwgZ2V0OiBkZWZpbml0aW9uW2tleV0gfSk7XG5cdFx0fVxuXHR9XG59OyIsIl9fd2VicGFja19yZXF1aXJlX18ubyA9IChvYmosIHByb3ApID0+IChPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwob2JqLCBwcm9wKSkiLCIvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG5fX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSAoZXhwb3J0cykgPT4ge1xuXHRpZih0eXBlb2YgU3ltYm9sICE9PSAndW5kZWZpbmVkJyAmJiBTeW1ib2wudG9TdHJpbmdUYWcpIHtcblx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgU3ltYm9sLnRvU3RyaW5nVGFnLCB7IHZhbHVlOiAnTW9kdWxlJyB9KTtcblx0fVxuXHRPYmplY3QuZGVmaW5lUHJvcGVydHkoZXhwb3J0cywgJ19fZXNNb2R1bGUnLCB7IHZhbHVlOiB0cnVlIH0pO1xufTsiLCIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbmltcG9ydCBNb2RhbCBmcm9tICcuLi9idXliYWNrL2FkbWluLm1vZGFsJztcblxuJChmdW5jdGlvbiAoKSB7XG4gICAgbGV0IG1vZGFsID0gbmV3IE1vZGFsKCdidXliYWNrLWNoYXQtbW9kYWwnKTtcbiAgICBsZXQgY2hhdEFjdGlvbnMgPSBuZXcgQ2hhdEFjdGlvbnMoKTtcbiAgICBsZXQgbWVzc2FnZUFjdGlvbnMgPSBuZXcgTWVzc2FnZUFjdGlvbnMoKTtcblxuICAgICQoJ2h0bWwsIGJvZHknKS5hbmltYXRlKHtcbiAgICAgICAgc2Nyb2xsVG9wOiAkKCcuYWQtYmItYWRtaW4tbWVzc2FnZScpLmxhc3QoKS5vZmZzZXQoKS50b3BcbiAgICAgICAgICAgIC0gJCgnLmhlYWRlci10b29sYmFyJykuaGVpZ2h0KClcbiAgICAgICAgICAgIC0gJCgnI2hlYWRlcl9pbmZvcycpLmhlaWdodCgpXG4gICAgfSwgMTAwMCk7XG5cbiAgICAkKCcuYWQtYmItYWRtaW4tY2hhdC1hY3Rpb25zIC5wcy1zd2l0Y2gnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGNoYXRBY3Rpb25zLnRvZ2dsZUFjdGl2ZUNoYXQodGhpcyk7XG4gICAgfSk7XG5cbiAgICAkKCcuYWQtYmItYWRtaW4tbXNnLWFjdGlvbnMgLnBzLXN3aXRjaCcpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbigpIHtcbiAgICAgICAgbWVzc2FnZUFjdGlvbnMudG9nZ2xlQWN0aXZlTWVzc2FnZSh0aGlzKTtcbiAgICB9KTtcblxuICAgICQoJy5hZC1iYi1hZG1pbi1jaGF0LWFjdGlvbnMtZGVsZXRlLCAuYWQtYmItYWRtaW4tbXNnLWFjdGlvbnMtZGVsZXRlJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICBtb2RhbC5zaG93KHRoaXMpO1xuICAgIH0pO1xufSk7XG5cbmNsYXNzIENoYXRBY3Rpb25zIHtcbiAgICB0b2dnbGVBY3RpdmVDaGF0KGNoYXQpIHtcbiAgICAgICAgbGV0IHVybCA9ICQoY2hhdCkuYXR0cignZGF0YS10b2dnbGUtdXJsJyk7XG4gICAgICAgIGxldCBzZWxmID0gdGhpcztcblxuICAgICAgICAkLnBvc3QodXJsLCBmdW5jdGlvbihkYXRhKSB7XG4gICAgICAgICAgICBpZiAoZGF0YS5zdGF0dXMgPT09IHRydWUpIHtcbiAgICAgICAgICAgICAgICAkLmdyb3dsKHttZXNzYWdlOiBkYXRhLm1lc3NhZ2V9KTtcbiAgICAgICAgICAgICAgICBzZWxmLmRpc2FibGVUZXh0YXJlYSgkKGNoYXQpLmZpbmQoJ2lucHV0OmNoZWNrZWQnKS52YWwoKSk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICQuZ3Jvd2wuZXJyb3Ioe21lc3NhZ2U6IGRhdGEubWVzc2FnZX0pO1xuICAgICAgICAgICAgfVxuICAgICAgICB9LCAnanNvbicpO1xuICAgIH1cblxuICAgIGRpc2FibGVUZXh0YXJlYShzdGF0dXMpIHtcbiAgICAgICAgJCgnI2J1eV9iYWNrX21lc3NhZ2VfbWVzc2FnZScpLmF0dHIoJ2Rpc2FibGVkJywgKHN0YXR1cyAgPT09ICcwJykpO1xuICAgICAgICAkKCdidXR0b246c3VibWl0JykuYXR0cignZGlzYWJsZWQnLCAoc3RhdHVzICA9PT0gJzAnKSk7XG4gICAgfVxufVxuXG5jbGFzcyBNZXNzYWdlQWN0aW9ucyB7XG4gICAgdG9nZ2xlQWN0aXZlTWVzc2FnZShtZXNzYWdlKSB7XG4gICAgICAgIGxldCB1cmwgPSAkKG1lc3NhZ2UpLmF0dHIoJ2RhdGEtdG9nZ2xlLXVybCcpO1xuXG4gICAgICAgICQucG9zdCh1cmwsIGZ1bmN0aW9uKGRhdGEpIHtcbiAgICAgICAgICAgIChkYXRhLnN0YXR1cyA9PT0gdHJ1ZSlcbiAgICAgICAgICAgICAgICA/ICQuZ3Jvd2woe21lc3NhZ2U6IGRhdGEubWVzc2FnZX0pXG4gICAgICAgICAgICAgICAgOiAkLmdyb3dsLmVycm9yKHttZXNzYWdlOiBkYXRhLm1lc3NhZ2V9KTtcbiAgICAgICAgfSwgJ2pzb24nKTtcbiAgICB9XG59XG4iXSwibmFtZXMiOltdLCJzb3VyY2VSb290IjoiIn0=