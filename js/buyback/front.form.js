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
