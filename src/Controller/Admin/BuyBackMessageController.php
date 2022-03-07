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

use AdBuyBack\Domain\BuyBack\Exception\BuyBackException;
use AdBuyBack\Domain\BuyBackMessage\Command\ActiveBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\ActiveBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\DeleteBulkBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\DeleteBuyBackMessageCommand;
use AdBuyBack\Domain\BuyBackMessage\Command\DuplicateBulkBuyBackMessageCommand;
use AdBuyBack\Grid\Filters\BuyBackMessageFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BuyBackMessageController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param BuyBackMessageFilters $filters
     * @param Request $request
     * @return Response
     */
    public function indexAction(BuyBackMessageFilters $filters, Request $request): Response
    {
        if ($chatId = (int)$request->get('chatId')) {
            $filters->addFilter(['id_ad_buyback_chat' => $chatId]);
        }

        $gridFactory = $this->get('adbuyback.grid.factory.buyback_message');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_message/index.html.twig', [
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
        $form = $this->get('adbuyback.form.form_builder.buyback_message')->getForm();
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_message');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The message has been successfully created.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_message_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_message/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $messageId
     * @param Request $request
     * @return Response
     */
    public function editAction(int $messageId, Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback_message')->getFormFor($messageId);
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_message');

        $form->handleRequest($request);

        try {
            if ($formHandler->handleFor($messageId, $form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The message has been successfully updated.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_message_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_message/edit.html.twig', [
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
        $messageId = (int)$request->get('messageId');

        try {
            $this->getCommandBus()->handle(new DeleteBuyBackMessageCommand($messageId));
            $this->addFlash('success', $this->trans('Message has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_message_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $messageId
     * @return JsonResponse
     */
    public function activeAction(int $messageId): JsonResponse
    {
        try {
            $this->getCommandBus()->handle(new ActiveBuyBackMessageCommand($messageId));

            $response = [
                'status' => true,
                'message' => $this->trans('The message status has been successfully updated.', 'Modules.Adbuyback.Alert'),
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
        $messageIds = $request->request->get('buybackMessage_bulk_action');

        try {
            $this->getCommandBus()->handle(new DuplicateBulkBuyBackMessageCommand($messageIds));
            $this->addFlash('success', $this->trans('The selection has been successfully duplicated.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_message_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function activeBulkAction(Request $request): RedirectResponse
    {
        $messageIds = $request->request->get('buybackMessage_bulk_action');
        $status = (bool)$request->get('status');

        try {
            $this->getCommandBus()->handle(new ActiveBulkBuyBackMessageCommand($messageIds, $status));
            $this->addFlash('success', $this->trans('The selection has been successfully ' . ($status ? 'enabled.' : 'disabled'), 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_message_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBulkAction(Request $request): RedirectResponse
    {
        $messageIds = $request->request->get('buybackMessage_bulk_action');

        try {
            $this->getCommandBus()->handle(new DeleteBulkBuyBackMessageCommand($messageIds));
            $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_message_index');
    }

    /**
     * @return array[]
     */
    private function getToolbarButtons(): array
    {
        return [
            'return' => [
                'href' => $this->generateUrl('admin_ad_buyback_chat_index'),
                'desc' => $this->trans('Return to chats', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-secondary',
                'icon' => 'navigate_before'
            ],
            'add' => [
                'href' => $this->generateUrl('admin_ad_buyback_message_create'),
                'desc' => $this->trans('New message', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-success',
                'icon' => 'add_circle_outline'
            ]
        ];
    }
}
