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

import ImagePreview from '../buyback_image/image.preview';
import ImageModal from '../buyback_image/admin.modal';

$(function () {
    let imagePreview = new ImagePreview('buyback-form-img-preview');
    let modal = new ImageModal('buyback-form-view-modal');

    $('#input-image').on('click', function() {
        $('#field-image').trigger('click');
    });

    $('#field-image').on('change', function() {
        imagePreview.init(this);
    });

    $('body').on('click', '.ad-bb-img-preview-btn', function() {
        modal.loadImageModal(this);
    });
});
