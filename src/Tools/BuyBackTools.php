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

namespace AdBuyBack\Tools;

use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use Context;
use Customer;
use Employee;
use FilesystemIterator;
use Gender;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class BuyBackTools
{
    /**
     * @param string $directory
     * @return void
     */
    public static function createDirectory(string $directory): void
    {
        if (!file_exists($directory)) {
            if (!mkdir($directory, 0777, true)) {
                throw new BuyBackException('Fail to create new directory');
            }

            if (!chmod($directory, 0777)) {
                throw new BuyBackException('Unable to grant permissions to the new directory');
            }
        }
    }

    /**
     * @param string $directory
     * @return void
     */
    public static function deleteDirectory(string $directory): void
    {
        if (!file_exists($directory)) {
            throw new BuyBackException('Fail to delete directory because is not exist');
        }

        $iterator = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if (!($file->isDir() ? rmdir($file->getRealPath()) : unlink($file->getRealPath()))) {
                throw new BuyBackException('Fail to delete file in directory');
            }
        }

        if (!rmdir($directory)) {
            throw new BuyBackException('Fail to delete directory');
        }
    }

    /**
     * @param $path
     * @return string
     */
    public static function changeFilenameForCopy($path): string
    {
        $infos = pathinfo($path);
        $infos['filename'] = preg_match('/(?<=\()\d+(?=\)+$)/', $infos['filename'], $matches)
            ? substr($infos['filename'], 0, -(strlen($matches[0]) + 2)) . '(' . ((int)$matches[0] + 1) . ')'
            : $infos['filename'] . '(2)';

        if (file_exists($infos['dirname'] . '/' . $infos['filename'] . '.' . $infos['extension'])) {
            return self::changeFilenameForCopy($infos['dirname'] . '/' . $infos['filename'] . '.' . $infos['extension']);
        }

        return $infos['filename'] . '.' . $infos['extension'];
    }

    /**
     * Get list of all genders for current language
     * Necessary due to a bug with ChoiceType and Object
     * @return array
     */
    public static function getGendersList(): array
    {
        $result = [];

        foreach (Gender::getGenders()->getResults() as $gender) {
            $result[$gender->name] = $gender->id_gender;
        }

        asort($result);

        return $result;
    }

    /**
     * Get list of all customers for current language
     * Necessary due to a bug with ChoiceType and Object
     * @return array
     */
    public static function getCustomersList(): array
    {
        $result = [];

        foreach (Customer::getCustomers(true) as $customer) {
            $fullname = $customer['firstname'] . ' ' . $customer['lastname'];
            $result[$fullname] = $customer['id_customer'];
        }

        arsort($result);

        return $result;
    }

    /**
     * Get list of all employees for current language
     * Necessary due to a bug with ChoiceType and Object
     * @return array
     */
    public static function getEmployeesList(): array
    {
        $result = [];

        foreach (Employee::getEmployees(true) as $employee) {
            $fullname = $employee['firstname'] . ' ' . $employee['lastname'];
            $result[$fullname] = $employee['id_employee'];
        }

        arsort($result);

        return $result;
    }
}
