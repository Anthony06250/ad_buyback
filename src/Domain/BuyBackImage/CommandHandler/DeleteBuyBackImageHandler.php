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

namespace AdBuyBack\Domain\BuyBackImage\CommandHandler;

use AdBuyBack\Domain\BuyBackImage\Command\DeleteBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotDeleteBuyBackImageException;
use AdBuyBack\Model\BuyBackImage;
use AdBuyBack\Tools\BuyBackTools;
use FilesystemIterator;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DeleteBuyBackImageHandler
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param DeleteBuyBackImageCommand $command
     * @return void
     */
    public function handle(DeleteBuyBackImageCommand $command): void
    {
        $imageId = $command->getId()->getValue();

        try {
            $image = new BuyBackImage($imageId);

            $this->deleteBuyBackImage($image);
            $this->deleteImageFile($image);
        } catch (PrestaShopException $exception) {
            throw new CannotDeleteBuyBackImageException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackImage $image
     * @return void
     * @throws PrestaShopException
     */
    public function deleteBuyBackImage(BuyBackImage $image): void
    {
        if (!$image->delete()) {
            throw new CannotDeleteBuyBackImageException($this->translator->trans(
                'Failed to delete image with id %imageId%.',
                ['%imageId%' => $image->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBackImage $image
     * @return void
     */
    public function deleteImageFile(BuyBackImage $image): void
    {
        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $image->id_ad_buyback . '/';

        if (!file_exists($directory . $image->name) || !unlink($directory . $image->name)) {
            throw new CannotDeleteBuyBackImageException($this->translator->trans(
                'Cannot delete image with id %imageId% for buyback with id %buybackId%.',
                ['%imageId%' => $image->id, '%buybackId%' => $image->id_ad_buyback],
                'Modules.Adbuyback.Alert'
            ));
        }

        if (!file_exists($directory . '/thumbnail/' . $image->name) || !unlink($directory . '/thumbnail/' . $image->name)) {
            throw new CannotDeleteBuyBackImageException($this->translator->trans(
                'Cannot delete thumbnail for image with id %imageId% for buyback with id %buybackId%.',
                ['%imageId%' => $image->id, '%buybackId%' => $image->id_ad_buyback],
                'Modules.Adbuyback.Alert'
            ));
        }

        if (iterator_count(new FilesystemIterator($directory, FilesystemIterator::SKIP_DOTS)) < 3) {
            BuyBackTools::deleteDirectory($directory);
        }
    }
}
