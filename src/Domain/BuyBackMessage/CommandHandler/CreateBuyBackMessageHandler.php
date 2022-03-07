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

namespace AdBuyBack\Domain\BuyBackMessage\CommandHandler;

use Ad_BuyBack;
use AdBuyBack\Domain\BuyBackChat\Query\GetIsActiveChat;
use AdBuyBack\Domain\BuyBackMessage\Command\CreateBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Exception\CannotCreateBuyBackMessageException;
use AdBuyBack\Domain\BuyBackMessage\ValueObject\BuyBackMessageId;
use AdBuyBack\Model\BuyBackMessage;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class CreateBuyBackMessageHandler
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
     * @param CreateBuyBackMessageCommand $command
     * @return BuyBackMessageId
     */
    public function handle(CreateBuyBackMessageCommand $command): BuyBackMessageId
    {
        try {
            $message = new BuyBackMessage();

            $this->createBuyBackMessage($message, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotCreateBuyBackMessageException($exception->getMessage());
        }

        return $command->getId()->setValue((int)$message->id);
    }

    /**
     * @param BuyBackMessage $message
     * @param CreateBuyBackMessageCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function createBuyBackMessage(BuyBackMessage $message, CreateBuyBackMessageCommand $command): void
    {
        $chatId = $command->getChatId();
        $isActive = $command->getIsActive();

        if ($isActive && !$this->commandBus->handle(new GetIsActiveChat($chatId))) {
            throw new CannotCreateBuyBackMessageException($this->translator->trans(
                'Failed to create message because chat is inactive.',
                [],
                'Modules.Adbuyback.Alert'
            ));
        }

        $message->hydrate($command->toArray());

        if (!$message->add()) {
            throw new CannotCreateBuyBackMessageException($this->translator->trans(
                'Failed to create message.',
                [],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
