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

use AdBuyBack\Domain\BuyBackImage\Command\DeleteBulkBuyBackImageCommand;
use AdBuyBack\Domain\BuyBackImage\Command\DeleteBuyBackImageCommand;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackImage\Command\DuplicateBulkBuyBackImageCommand;
use AdBuyBack\Grid\Filters\BuyBackImageFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BuyBackImageController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param BuyBackImageFilters $filters
     * @return Response
     */
    public function indexAction(BuyBackImageFilters $filters): Response
    {
        $gridFactory = $this->get('adbuyback.grid.factory.buyback_image');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_image/index.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'grid' => $this->presentGrid($grid)
        ]);
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $imageId = (int)$request->get('imageId');

        try {
            $this->getCommandBus()->handle(new DeleteBuyBackImageCommand($imageId));
            $this->addFlash('success', $this->trans('Image has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_image_index');
    }

    /**
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function duplicateBulkAction(Request $request): RedirectResponse
    {
        $imageIds = $request->request->get('buybackImage_bulk_action');

        try {
            $this->getCommandBus()->handle(new DuplicateBulkBuyBackImageCommand($imageIds));
            $this->addFlash('success', $this->trans('The selection has been successfully duplicated.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_image_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBulkAction(Request $request): RedirectResponse
    {
        $imageIds = $request->request->get('buybackImage_bulk_action');

        try {
            $this->getCommandBus()->handle(new DeleteBulkBuyBackImageCommand($imageIds));
            $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_image_index');
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons(): array
    {
        return [
            'return' => [
                'href' => $this->generateUrl('admin_ad_buyback_index'),
                'desc' => $this->trans('Return to buybacks', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-secondary',
                'icon' => 'navigate_before'
            ]
        ];
    }
}
