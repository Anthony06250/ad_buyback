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

use AdBuyBack\Domain\BuyBack\Command\ActiveBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DeleteBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DuplicateBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\ActiveBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackImage\Command\DeleteBuyBackImageCommand;
use AdBuyBack\Grid\Filters\BuyBackFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BuyBackController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param BuyBackFilters $filters
     * @return Response
     */
    public function indexAction(BuyBackFilters $filters): Response
    {
        $gridFactory = $this->get('adbuyback.grid.factory.buyback');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback/index.html.twig', [
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
        $form = $this->get('adbuyback.form.form_builder.buyback')->getForm();
        $formHandler = $this->get('adbuyback.form.form_handler.buyback');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The buyback has been successfully created.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $buybackId
     * @param Request $request
     * @return Response
     */
    public function editAction(int $buybackId, Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback')->getFormFor($buybackId);
        $formHandler = $this->get('adbuyback.form.form_handler.buyback');

        $form->handleRequest($request);

        try {
            if ($formHandler->handleFor($buybackId, $form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The buyback has been successfully updated.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_edit', ['buybackId' => $buybackId]);
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback/edit.html.twig', [
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
        $buybackId = (int)$request->get('buybackId');

        try {
            $this->getCommandBus()->handle(new DeleteBuyBackCommand($buybackId));
            $this->addFlash('success', $this->trans('The buyback has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteImageAction(Request $request): RedirectResponse
    {
        $imageId = (int)$request->get('imageId');
        $buybackId = (int)$request->get('buy_back')['id_ad_buyback'];

        try {
            $this->getCommandBus()->handle(new DeleteBuyBackImageCommand($imageId));
            $this->addFlash('success', $this->trans('The image has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_edit', ['buybackId' => $buybackId]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $buybackId
     * @return JsonResponse
     */
    public function activeAction(int $buybackId): JsonResponse
    {
        try {
            $this->getCommandBus()->handle(new ActiveBuyBackCommand($buybackId));

            $response = [
                'status' => true,
                'message' => $this->trans('The buyback status has been successfully updated.', 'Modules.Adbuyback.Alert'),
            ];
        } catch (BuyBackException $exception) {
            $response = [
                'status' => false,
                'message' => $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'),
            ];
        }

        return $this->json($response);
    }

    /**
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function duplicateBulkAction(Request $request): RedirectResponse
    {
        $buybackIds = $request->request->get('buyback_bulk_action');

        try {
            $this->getCommandBus()->handle(new DuplicateBulkBuyBackCommand($buybackIds));
            $this->addFlash('success', $this->trans('The selection has been successfully duplicated.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function activeBulkAction(Request $request): RedirectResponse
    {
        $buybackIds = $request->request->get('buyback_bulk_action');
        $status = (bool)$request->get('status');

        try {
            $this->getCommandBus()->handle(new ActiveBulkBuyBackCommand($buybackIds, $status));
            $this->addFlash('success', $this->trans('The selection has been successfully ' . ($status ? 'enabled.' : 'disabled'), 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBulkAction(Request $request): RedirectResponse
    {
        $buybackIds = $request->request->get('buyback_bulk_action');

        try {
            $this->getCommandBus()->handle(new DeleteBulkBuyBackCommand($buybackIds));
            $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_index');
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons(): array
    {
        return [
            'add' => [
                'href' => $this->generateUrl('admin_ad_buyback_create'),
                'desc' => $this->trans('New buyback', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-success',
                'icon' => 'add_circle_outline'
            ],
            'images' => [
                'href' => $this->generateUrl('admin_ad_buyback_image_index'),
                'desc' => $this->trans('View all images', 'Modules.Adbuyback.Admin'),
                'icon' => 'photo_library'
            ],
            'chat' => [
                'href' => $this->generateUrl('admin_ad_buyback_chat_index'),
                'desc' => $this->trans('View all chats', 'Modules.Adbuyback.Admin'),
                'icon' => 'chat'
            ]
        ];
    }
}
