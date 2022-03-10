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

