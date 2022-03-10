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
    let imagePreview = new ImagePreview('buyback-form-img-preview');

    $('#input-image').on('click', function() {
        $('#field-image').trigger('click');
    });


    $('#field-image').on('change', function() {
        getImageFieldName(this);
        imagePreview.init(this);
    });
});

function getImageFieldName(field) {
    let count = $(field.files).length;
    let label = $(field).attr('data-multiple-files-text').replace('%count%', count);

    $('#input-image').val(count > 1 ? label : field.files[0].name);
}

class ImagePreview {
    constructor(preview) {
        this.preview = $('#' + preview);
    }

    init(trigger) {
        let self = this;

        if (trigger.files && trigger.files[0]) {
            this.preview.find('article').remove();
            $.each(trigger.files, function(key, file) {
                self.previewImage(file);
            });
        }
    }

    previewImage(file) {
        let reader = new FileReader();
        let self = this;

        reader.onload = function (event) {
            self.preview.append($('<article class="col-md-2 mb-2">')
                .append($('<figure class="m-0">')
                    .append($('<img class="img-thumbnail" src="' + event.target.result + '" alt="' + file.name + '">'))
                    .append($('<figcaption>')
                        .append($('<small>').html(self.formatFilename(file.name))))));
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


/******/ })()
;
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYnV5YmFjay5mcm9udC5mb3JtLmJ1bmRsZS5qcyIsIm1hcHBpbmdzIjoiOzs7OztBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLOzs7QUFHTDtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0wsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYTtBQUNiO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYWQvYnV5YmFjay8uL2J1eWJhY2svZnJvbnQuZm9ybS5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICogQ29weXJpZ2h0IHNpbmNlIDIwMDcgUHJlc3RhU2hvcCBTQSBhbmQgQ29udHJpYnV0b3JzXG4gKiBQcmVzdGFTaG9wIGlzIGFuIEludGVybmF0aW9uYWwgUmVnaXN0ZXJlZCBUcmFkZW1hcmsgJiBQcm9wZXJ0eSBvZiBQcmVzdGFTaG9wIFNBXG4gKlxuICogTk9USUNFIE9GIExJQ0VOU0VcbiAqXG4gKiBUaGlzIHNvdXJjZSBmaWxlIGlzIHN1YmplY3QgdG8gdGhlIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICogdGhhdCBpcyBidW5kbGVkIHdpdGggdGhpcyBwYWNrYWdlIGluIHRoZSBmaWxlIExJQ0VOU0UubWQuXG4gKiBJdCBpcyBhbHNvIGF2YWlsYWJsZSB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiBhdCB0aGlzIFVSTDpcbiAqIGh0dHBzOi8vb3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvQUZMLTMuMFxuICogSWYgeW91IGRpZCBub3QgcmVjZWl2ZSBhIGNvcHkgb2YgdGhlIGxpY2Vuc2UgYW5kIGFyZSB1bmFibGUgdG9cbiAqIG9idGFpbiBpdCB0aHJvdWdoIHRoZSB3b3JsZC13aWRlLXdlYiwgcGxlYXNlIHNlbmQgYW4gZW1haWxcbiAqIHRvIGxpY2Vuc2VAcHJlc3Rhc2hvcC5jb20gc28gd2UgY2FuIHNlbmQgeW91IGEgY29weSBpbW1lZGlhdGVseS5cbiAqXG4gKiBAYXV0aG9yICAgIFByZXN0YVNob3AgU0EgYW5kIENvbnRyaWJ1dG9ycyA8Y29udGFjdEBwcmVzdGFzaG9wLmNvbT5cbiAqIEBjb3B5cmlnaHQgU2luY2UgMjAwNyBQcmVzdGFTaG9wIFNBIGFuZCBDb250cmlidXRvcnNcbiAqIEBsaWNlbnNlICAgaHR0cHM6Ly9vcGVuc291cmNlLm9yZy9saWNlbnNlcy9BRkwtMy4wIEFjYWRlbWljIEZyZWUgTGljZW5zZSB2ZXJzaW9uIDMuMFxuICovXG5cbiQoZnVuY3Rpb24gKCkge1xuICAgIGxldCBpbWFnZVByZXZpZXcgPSBuZXcgSW1hZ2VQcmV2aWV3KCdidXliYWNrLWZvcm0taW1nLXByZXZpZXcnKTtcblxuICAgICQoJyNpbnB1dC1pbWFnZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAkKCcjZmllbGQtaW1hZ2UnKS50cmlnZ2VyKCdjbGljaycpO1xuICAgIH0pO1xuXG5cbiAgICAkKCcjZmllbGQtaW1hZ2UnKS5vbignY2hhbmdlJywgZnVuY3Rpb24oKSB7XG4gICAgICAgIGdldEltYWdlRmllbGROYW1lKHRoaXMpO1xuICAgICAgICBpbWFnZVByZXZpZXcuaW5pdCh0aGlzKTtcbiAgICB9KTtcbn0pO1xuXG5mdW5jdGlvbiBnZXRJbWFnZUZpZWxkTmFtZShmaWVsZCkge1xuICAgIGxldCBjb3VudCA9ICQoZmllbGQuZmlsZXMpLmxlbmd0aDtcbiAgICBsZXQgbGFiZWwgPSAkKGZpZWxkKS5hdHRyKCdkYXRhLW11bHRpcGxlLWZpbGVzLXRleHQnKS5yZXBsYWNlKCclY291bnQlJywgY291bnQpO1xuXG4gICAgJCgnI2lucHV0LWltYWdlJykudmFsKGNvdW50ID4gMSA/IGxhYmVsIDogZmllbGQuZmlsZXNbMF0ubmFtZSk7XG59XG5cbmNsYXNzIEltYWdlUHJldmlldyB7XG4gICAgY29uc3RydWN0b3IocHJldmlldykge1xuICAgICAgICB0aGlzLnByZXZpZXcgPSAkKCcjJyArIHByZXZpZXcpO1xuICAgIH1cblxuICAgIGluaXQodHJpZ2dlcikge1xuICAgICAgICBsZXQgc2VsZiA9IHRoaXM7XG5cbiAgICAgICAgaWYgKHRyaWdnZXIuZmlsZXMgJiYgdHJpZ2dlci5maWxlc1swXSkge1xuICAgICAgICAgICAgdGhpcy5wcmV2aWV3LmZpbmQoJ2FydGljbGUnKS5yZW1vdmUoKTtcbiAgICAgICAgICAgICQuZWFjaCh0cmlnZ2VyLmZpbGVzLCBmdW5jdGlvbihrZXksIGZpbGUpIHtcbiAgICAgICAgICAgICAgICBzZWxmLnByZXZpZXdJbWFnZShmaWxlKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgcHJldmlld0ltYWdlKGZpbGUpIHtcbiAgICAgICAgbGV0IHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG4gICAgICAgIGxldCBzZWxmID0gdGhpcztcblxuICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgICAgICAgICBzZWxmLnByZXZpZXcuYXBwZW5kKCQoJzxhcnRpY2xlIGNsYXNzPVwiY29sLW1kLTIgbWItMlwiPicpXG4gICAgICAgICAgICAgICAgLmFwcGVuZCgkKCc8ZmlndXJlIGNsYXNzPVwibS0wXCI+JylcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZCgkKCc8aW1nIGNsYXNzPVwiaW1nLXRodW1ibmFpbFwiIHNyYz1cIicgKyBldmVudC50YXJnZXQucmVzdWx0ICsgJ1wiIGFsdD1cIicgKyBmaWxlLm5hbWUgKyAnXCI+JykpXG4gICAgICAgICAgICAgICAgICAgIC5hcHBlbmQoJCgnPGZpZ2NhcHRpb24+JylcbiAgICAgICAgICAgICAgICAgICAgICAgIC5hcHBlbmQoJCgnPHNtYWxsPicpLmh0bWwoc2VsZi5mb3JtYXRGaWxlbmFtZShmaWxlLm5hbWUpKSkpKSk7XG4gICAgICAgIH07XG5cbiAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoZmlsZSk7XG4gICAgfVxuXG4gICAgZm9ybWF0RmlsZW5hbWUoZmlsZW5hbWUpIHtcbiAgICAgICAgbGV0IG5hbWUgPSBmaWxlbmFtZS5zcGxpdCgnLicpLnNsaWNlKDAsIC0xKS5qb2luKCcuJyk7XG5cbiAgICAgICAgaWYgKG5hbWUubGVuZ3RoID4gMjMpIHtcbiAgICAgICAgICAgIHJldHVybiBuYW1lLnNsaWNlKDAsIDE1KSArICcuLi4nO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIG5hbWU7XG4gICAgfVxufVxuXG4iXSwibmFtZXMiOltdLCJzb3VyY2VSb290IjoiIn0=