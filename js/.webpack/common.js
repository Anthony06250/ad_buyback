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

const path = require('path');

module.exports = {
    entry: {
        'buyback.admin.index': './buyback/admin.index.js',
        'buyback.admin.edit': './buyback/admin.edit.js',
        'buyback_image.admin.index': './buyback_image/admin.index.js',
        'buyback_image.admin.edit': './buyback_image/admin.edit.js',
        'buyback_chat.admin.index': './buyback_chat/admin.index.js',
        'buyback_chat.admin.view': './buyback_chat/admin.view.js',
        'buyback_message.admin.index': './buyback_message/admin.index.js',
        'buyback_message.admin.edit': './buyback_message/admin.edit.js',
        'buyback.front.form': './buyback/front.form.js',
        'buyback_chat.front.chat': './buyback_chat/front.chat.js'
    },
    output: {
        path: path.resolve(__dirname, '../../views/js'),
        filename: '[name].bundle.js',
        publicPath: 'public',
    },
}
