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

namespace AdBuyBack\Controller\Admin;

use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackImageCommand;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBack\Exception\CannotDeleteBuyBackImageException;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class BuyBackImageController extends FrameworkBundleAdminController
{
    /**
     * -> TODO: Make deleteBulkAction() and insert when deleting BuyBack
     */

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $id = (int)$request->get('id');
        $buybackId = (int)$request->get('buy_back_image')['id_ad_buyback'];
        $directory = _PS_MODULE_DIR_ . 'ad_buyback/views/img/buyback/' . $buybackId . '/';

        $handler = $this->get('adbuyback.domain.buyback_image.command_handler.delete');

        try {
            $handler->handle(new DeleteBuyBackImageCommand($id));
            $this->deleteImage($directory . $request->get('filename'), $buybackId);
            $this->addFlash('success', $this->trans('Buy back image has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_edit', ['id' => $buybackId]);
    }

    /**
     * @param $path
     * @param $buybackId
     * @return void
     */
    private function deleteImage($path, $buybackId): void
    {
        if (!file_exists($path) || !unlink($path)) {
            throw new CannotDeleteBuyBackImageException(sprintf('Cannot delete image for buyback with id "%s"', $buybackId));
        }
    }
}
