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
use AdBuyBack\Domain\BuyBackImage\Command\CreateBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Exception\CannotCreateBuyBackImageException;
use AdBuyBack\Domain\BuyBackImage\ValueObject\BuyBackImageId;
use AdBuyBack\Model\BuyBackImage;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

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

            $this->createBuyBackImage($image, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackImageException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$image->id);
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
