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

namespace AdBuyBack\Domain\BuyBack\CommandHandler;

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBack\Command\CreateBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\CannotCreateBuyBackException;
use AdBuyBack\Domain\BuyBack\ValueObject\BuyBackId;
use AdBuyBack\Domain\BuyBackChat\Command\CreateBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\CreateBuyBackMessageCommand;
use AdBuyBack\Model\BuyBack;
use AdBuyBack\Tools\BuyBackTools;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class CreateBuyBackHandler extends ImageBuyBackHandler
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

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
        $this->commandBus = Ad_BuyBack::getService('prestashop.core.command_bus');
        $this->translator = Ad_BuyBack::getService('translator');
    }

    /**
     * @param CreateBuyBackCommand $command
     * @return BuyBackId
     */
    public function handle(CreateBuyBackCommand $command): BuyBackId
    {
        try {
            $buyback = new BuyBack();

            $this->createBuyBack($buyback, $command);
            $this->createBuyBackImage($buyback, $command);
            $this->createBuyBackChat($buyback, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$buyback->id);
    }

    /**
     * @param BuyBack $buyback
     * @param CreateBuyBackCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function createBuyBack(BuyBack &$buyback, CreateBuyBackCommand $command): void
    {
        $buyback->hydrate($command->toArray());

        if (!$buyback->add()) {
            throw new CannotCreateBuyBackException($this->translator->trans(
                'Failed to create buyback.', [],
                'Modules.Adbuyback.Alert'
            ));
        }
    }

    /**
     * @param BuyBack $buyback
     * @param CreateBuyBackCommand $command
     * @return void
     */
    private function createBuyBackChat(BuyBack $buyback, CreateBuyBackCommand $command): void
    {
        if ($command->getMessage()) {
            $chatId = $this->commandBus->handle((new CreateBuyBackChatCommand())->fromArray([
                'id_ad_buyback' => $buyback->id,
                'active' => $buyback->active,
                'token' => BuyBackTools::getToken()
            ]));

            $this->createBuyBackMessage($chatId->getValue(), $command);
        }
    }

    /**
     * @param int $chatId
     * @param CreateBuyBackCommand $command
     * @return void
     */
    private function createBuyBackMessage(int $chatId, CreateBuyBackCommand $command): void
    {
        $this->commandBus->handle((new CreateBuyBackMessageCommand())->fromArray([
            'id_ad_buyback_chat' => $chatId,
            'id_customer' => $command->getCustomer(),
            'id_employee' => $command->getEmployee(),
            'active' => true,
            'message' => $command->getMessage(),
            'isActive' => false
        ]));
    }
}
