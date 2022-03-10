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
     * @param Request $request
     * @return Response
     */
    public function indexAction(BuyBackImageFilters $filters, Request $request): Response
    {
        if ($buybackId = (int)$request->get('buybackId')) {
            $filters->addFilter(['id_ad_buyback' => $buybackId]);
        }

        $gridFactory = $this->get('adbuyback.grid.factory.buyback_image');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_image/index.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'grid' => $this->presentGrid($grid)
        ]);
    }

    /**
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback_image')->getForm();
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_image');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The image has been successfully created.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_image_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_image/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $imageId
     * @param Request $request
     * @return Response
     */
    public function editAction(int $imageId, Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback_image')->getFormFor($imageId);
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_image');

        $form->handleRequest($request);

        try {
            if ($formHandler->handleFor($imageId, $form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The image has been successfully updated.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_image_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_image/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
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
            $this->addFlash('error', $exception->getMessage());
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
            $this->addFlash('error', $exception->getMessage());
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
            $this->addFlash('error', $exception->getMessage());
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
            ],
            'add' => [
                'href' => $this->generateUrl('admin_ad_buyback_image_create'),
                'desc' => $this->trans('New image', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-success',
                'icon' => 'add_circle_outline'
            ]
        ];
    }
}
