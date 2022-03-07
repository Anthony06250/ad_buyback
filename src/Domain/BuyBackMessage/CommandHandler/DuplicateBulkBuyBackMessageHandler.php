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

use AdBuyBack\Domain\BuyBackMessage\Command\DuplicateBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Exception\CannotDuplicateBulkBuyBackMessageException;
use AdBuyBack\Model\BuyBackMessage;
use PrestaShopBundle\Translation\TranslatorInterface;
use PrestaShopException;

final class DuplicateBulkBuyBackMessageHandler
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
     * @param DuplicateBulkBuyBackMessageCommand $command
     * @return void
     */
    public function handle(DuplicateBulkBuyBackMessageCommand $command): void
    {
        $messageIds = $command->getId()->getValue();
        $chatId = $command->getChatId();

        try {
            foreach ($this->getBuyBackMessage($messageIds) as $message) {
                $this->duplicateBuyBackMessage($message, $chatId);
            }
        } catch (PrestaShopException $exception) {
            throw new CannotDuplicateBulkBuyBackMessageException($exception->getMessage());
        }
    }

    /**
     * @param array $messageIds
     * @return array
     * @throws PrestaShopException
     */
    private function getBuyBackMessage(array $messageIds): array
    {
        foreach ($messageIds as $key => $messageId) {
            $messageIds[$key] = new BuyBackMessage($messageId);
        }

        return $messageIds;
    }

    /**
     * @param BuyBackMessage $message
     * @param int|null $chatId
     * @return void
     * @throws PrestaShopException
     */
    private function duplicateBuyBackMessage(BuyBackMessage &$message, ?int $chatId): void
    {
        $message = $message->duplicateObject();

        if ($chatId) {
            $message->id_ad_buyback_chat = $chatId;
        }

        if (!$message->save()) {
            throw new CannotDuplicateBulkBuyBackMessageException($this->translator->trans(
                'Failed to duplicate message with id %messageId%.',
                ['%messageId%' => $message->id],
                'Modules.Adbuyback.Alert'
            ));
        }
    }
}
