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

namespace AdBuyBack\Form\DataHandler;

use AdBuyBack\Domain\BuyBack\Command\CreateBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\EditBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use DateTime;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;

final class BuyBackFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param array $data
     * @return int
     * @throws BuyBackException
     */
    public function create(array $data): int
    {
        $command = (new CreateBuyBackCommand())->fromArray($data);
        $response = $this->commandBus->handle($command);

        return $response->getValue();
    }

    /**
     * @param $id
     * @param array $data
     * @return void
     * @throws BuyBackException
     */
    public function update($id, array $data): void
    {
        $data['date_upd'] = (new DateTime())->format('Y-m-d H:i:s');
        $command = (new EditBuyBackCommand((int)$id))->fromArray($data);

        $this->commandBus->handle($command);
    }
}
