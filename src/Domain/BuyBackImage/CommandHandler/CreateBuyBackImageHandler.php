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

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackImage\Command\CreateBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotCreateBuyBackImageException;
use AdBuyBack\Domain\BuyBackImage\ValueObject\BuyBackImageId;
use AdBuyBack\Model\BuyBackImage;
use AdBuyBack\Tools\BuyBackTools;
use AdBuyBack\Uploader\BuyBackExtraImageUploader;
use PrestaShop\PrestaShop\Core\Image\Exception\ImageException;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class CreateBuyBackImageHandler
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     *
     */
    public function __construct()
    {
        // Use custom kernel for front office
        $this->translator = Ad_BuyBack::getService('translator');
    }

    /**
     * @param CreateBuyBackImageCommand $command
     * @return BuyBackImageId
     */
    public function handle(CreateBuyBackImageCommand $command): BuyBackImageId
    {
        try {
            $image = new BuyBackImage();

            $this->createImageFile($command);
            $this->createBuyBackImage($image, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackImageException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$image->id);
    }

    /**
     * @param CreateBuyBackImageCommand $command
     * @return void
     */
    private function createImageFile(CreateBuyBackImageCommand &$command): void
    {
        $imageFile = $command->getImage();

        if (!$imageFile instanceof UploadedFile) {
            throw new CannotCreateBuyBackImageException($this->translator->trans(
                'This file is not a valid image.',
                [],
                'Modules.Adbuyback.Alert'
            ));
        }

        try {
            $uploader = new BuyBackExtraImageUploader();
            $buybackId = $command->getBuyBackId();
            $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $buybackId . '/';
            $imageName = $imageFile->getClientOriginalName();

            if (file_exists($directory . $imageName)) {
                $imageName = BuyBackTools::changeFilenameForCopy($directory . $imageName);
            }

            $command->setName($imageName);
            $uploader->upload($buybackId, $imageFile, $imageName);
        } catch (ImageException $exception) {
            throw new BuyBackException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackImage $image
     * @param CreateBuyBackImageCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function createBuyBackImage(BuyBackImage $image, CreateBuyBackImageCommand $command): void
    {
        $image->hydrate($command->toArray());

        if (!$image->add()) {
            throw new CannotCreateBuyBackImageException($this->translator->trans(
                'Failed to create buyback image.',
                [],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
