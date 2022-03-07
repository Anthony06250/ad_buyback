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

use AdBuyBack\Domain\BuyBackMessage\Command\EditBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Exception\CannotEditBuyBackMessageException;
use AdBuyBack\Model\BuyBackMessage;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class EditBuyBackMessageHandler
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
     * @param EditBuyBackMessageCommand $command
     * @return void
     */
    public function handle(EditBuyBackMessageCommand $command): void
    {
        $messageId = $command->getId()->getValue();

        try {
            $message = new BuyBackMessage($messageId);

            $this->editBuyBackMessage($message, $command);
        } catch (PrestaShopException $exception) {
            throw new CannotEditBuyBackMessageException($exception->getMessage());
        }
    }

    /**
     * @param BuyBackMessage $message
     * @param EditBuyBackMessageCommand $command
     * @return void
     * @throws PrestaShopException
     */
    private function editBuyBackMessage(BuyBackMessage $message, EditBuyBackMessageCommand $command): void
    {
        $message->hydrate($command->toArray());

        if (!$message->update()) {
            throw new CannotEditBuyBackMessageException($this->translator->trans(
                'Failed to update message with id %messageId%.',
                ['%messageId%' => $message->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
