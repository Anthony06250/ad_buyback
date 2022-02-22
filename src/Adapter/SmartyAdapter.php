<?php
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

declare(strict_types=1);

namespace AdBuyBack\Adapter;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormErrorIterator;

final class SmartyAdapter
{
    /**
     * @param Form $form
     * @return array
     */
    public static function convertTwigFormToSmarty(Form $form): array
    {
        $form = $form->createView();
        $excludedFields = ['id_ad_buyback', 'active'];
        $excludedVars = ['form', 'errors', 'block_prefixes'];
        $result = [];

        foreach ($form->vars as $key => $value) {
            if (!in_array($key, $excludedVars)) {
                $result['options'][$key] = $value;
            }
        }
        foreach ($form->children as $children) {
            foreach ($children->vars as $key => $value) {
                if (!in_array($children->vars['name'], $excludedFields)) {
                    if ($key == 'errors') {
                        $result['fields'][$children->vars['name']]['type'] = SmartyAdapter::getFieldType($value);
                    }
                    else if (!in_array($key, $excludedVars)) {
                        $result['fields'][$children->vars['name']][$key] = $value;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param FormErrorIterator $field
     * @return string
     */
    private static function getFieldType(FormErrorIterator $field): string
    {
        $type = get_class($field->getForm()->getConfig()->getType()->getInnerType());
        $type = substr($type, (strrpos($type,'\\') + 1));
        $regex = '/
            (?<=[a-z])          # Position is after a lowercase,
            (?=[A-Z])           # and before an uppercase letter.
            | (?<=[A-Z])        # Or g2of2; Position is after uppercase,
            (?=[A-Z][a-z])      # and before upper-then-lower case.
            /x';
        // Source : https://stackoverflow.com/questions/4519739/split-camelcase-word-into-words-with-php-preg-match-regular-expression

        return strtolower(preg_split($regex, $type)[0]);
    }
}
