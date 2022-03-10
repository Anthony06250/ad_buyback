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

use AdBuyBack\Domain\BuyBackImage\Command\EditBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotEditBuyBackImageException;
use AdBuyBack\Model\BuyBackImage;
use AdBuyBack\Tools\BuyBackTools;
use FilesystemIterator;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class EditBuyBackImageHandler
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
     * @param EditBuyBackImageCommand $command
     * @return void
     */
    public function handle(EditBuyBackImageCommand $command): void
    {
        $imageId = $command->getId()->getValue();

        try {
            $image = new BuyBackImage($imageId);

            $this->editImageFile($image, $command);
            $this->editBuyBackImage($image, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotEditBuyBackImageException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackImage $image
     * @param EditBuyBackImageCommand $command
     * @return void
     */
    public function editImageFile(BuyBackImage $image, EditBuyBackImageCommand $command): void
    {
        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $image->id_ad_buyback . '/';
        $destination = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $command->getBuyBackId() . '/';

        if (!file_exists($destination)) {
            BuyBackTools::createDirectory($destination . 'thumbnail/');
            if (!copy($directory . 'fileType', $destination . 'fileType')
                || !copy($directory . 'thumbnail/fileType', $destination . 'thumbnail/fileType')) {
                throw new CannotEditBuyBackImageException($this->translator->trans(
                    'Fail to create directory for image with id %imageId% for buyback with id %buybackId%.',
                    ['%imageId%' => $image->id, '%buybackId%' => $image->id_ad_buyback],
                    'Modules.Adbuyback.Alert'
                ));
            }
        }

        if (!rename($directory . $image->name, $destination . $command->getName())
            || !rename($directory . 'thumbnail/' . $image->name, $destination . 'thumbnail/' . $command->getName())) {
            throw new CannotEditBuyBackImageException($this->translator->trans(
                'Cannot move image with id %imageId% for buyback with id %buybackId%.',
                ['%imageId%' => $image->id, '%buybackId%' => $image->id_ad_buyback],
                'Modules.Adbuyback.Alert'
            ));
        }

        if (iterator_count(new FilesystemIterator($directory, FilesystemIterator::SKIP_DOTS)) < 3) {
            BuyBackTools::deleteDirectory($directory);
        }
    }

    /**
     * @param BuyBackImage $image
     * @param EditBuyBackImageCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function editBuyBackImage(BuyBackImage $image, EditBuyBackImageCommand $command): void
    {
        $image->hydrate($command->toArray());

        if (!$image->update()) {
            throw new CannotEditBuyBackImageException($this->translator->trans(
                'Failed to update image with id %imageId%.',
                ['%imageId%' => $image->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
