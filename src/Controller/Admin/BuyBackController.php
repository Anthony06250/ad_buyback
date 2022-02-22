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

use AdBuyBack\Domain\BuyBack\Command\ToggleActiveBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DeleteBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DeleteBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\DuplicateBulkBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Command\ToggleActiveBuyBackCommand;
use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
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
            ]
        );
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
            if ($formHandler->handle($form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The buy back has been successfully created.', 'Modules.Adbuyback.Alert'));

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
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editAction(int $id, Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback_image')->getFormFor($id);
        $formHandler = $this->get('adbuyback.form.form_handler.buyback');

        $form->handleRequest($request);

        try {
            if ($formHandler->handleFor($id, $form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The buy back has been successfully updated.', 'Modules.Adbuyback.Alert'));

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
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $id = (int)$request->get('id');
        $handler = $this->get('adbuyback.domain.buyback.command_handler.delete');

        try {
            $handler->handle(new DeleteBuyBackCommand($id));
            $this->addFlash('success', $this->trans('Buy back has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $id
     * @return JsonResponse
     */
    public function toggleActiveAction(int $id): JsonResponse
    {
        $handler = $this->get('adbuyback.domain.buyback.command_handler.toggle_active');

        try {
            $handler->handle(new ToggleActiveBuyBackCommand($id));

            $response = [
                'status' => true,
                'message' => $this->trans('The buy back status has been successfully updated.', 'Modules.Adbuyback.Alert'),
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
        $ids = $request->request->get('buyback_bulk_action');
        $handler = $this->get('adbuyback.domain.buyback.command_handler.duplicate_bulk');

        try {
            $handler->handle(new DuplicateBulkBuyBackCommand($ids));
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
    public function toggleActiveBulkAction(Request $request): RedirectResponse
    {
        $ids = $request->request->get('buyback_bulk_action');
        $status = (bool)$request->get('status');
        $handler = $this->get('adbuyback.domain.buyback.command_handler.active_bulk');

        try {
            $handler->handle(new ToggleActiveBulkBuyBackCommand($ids, $status));
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
        $ids = $request->request->get('buyback_bulk_action');
        $handler = $this->get('adbuyback.domain.buyback.command_handler.delete_bulk');

        try {
            $handler->handle(new DeleteBulkBuyBackCommand($ids));
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
                'desc' => $this->trans('New buy back', 'Modules.Adbuyback.Admin'),
                'icon' => 'add_circle_outline',
            ],
        ];
    }
}
