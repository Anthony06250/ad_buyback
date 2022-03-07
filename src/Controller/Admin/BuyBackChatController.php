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
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Command\ActiveBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Command\DeleteBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Command\DeleteBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Command\DuplicateBulkBuyBackChatCommand;
use AdBuyBack\Domain\BuyBackChat\Query\GetChatForForm;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForChat;
use AdBuyBack\Grid\Filters\BuyBackChatFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyBackChatController extends FrameworkBundleAdminController
{
    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param BuyBackChatFilters $filters
     * @param Request $request
     * @return Response
     */
    public function indexAction(BuyBackChatFilters $filters, Request $request): Response
    {
        if ($buybackId = (int)$request->get('buybackId')) {
            $filters->addFilter(['id_ad_buyback' => $buybackId]);
        }

        $gridFactory = $this->get('adbuyback.grid.factory.buyback_chat');
        $grid = $gridFactory->getGrid($filters);

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_chat/index.html.twig', [
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
        $form = $this->get('adbuyback.form.form_builder.buyback_chat')->getForm();
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_chat');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The chat has been successfully created.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_chat_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_chat/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('create', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return Response
     */
    public function createMessageAction(Request $request): Response
    {
        $chatId = $request->get('buy_back_message')['id_ad_buyback_chat'];
        $form = $this->get('adbuyback.form.form_builder.buyback_message')->getForm();
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_message');

        $form->handleRequest($request);

        try {
            if ($formHandler->handle($form)->getIdentifiableObjectId()) {
                $this->addFlash('success', $this->trans('The message has been successfully created.', 'Modules.Adbuyback.Alert'));
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_chat_view', ['chatId' => $chatId]);
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $chatId
     * @param Request $request
     * @return Response
     */
    public function editAction(int $chatId, Request $request): Response
    {
        $form = $this->get('adbuyback.form.form_builder.buyback_chat')->getFormFor($chatId);
        $formHandler = $this->get('adbuyback.form.form_handler.buyback_chat');

        $form->handleRequest($request);

        try {
            if ($formHandler->handleFor($chatId, $form)->getIdentifiableObjectId() !== null) {
                $this->addFlash('success', $this->trans('The chat has been successfully updated.', 'Modules.Adbuyback.Alert'));

                return $this->redirectToRoute('admin_ad_buyback_chat_index');
            }
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_chat/edit.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return Response
     */
    public function viewAction(Request $request): Response
    {
        $chatId = (int)$request->get('chatId');
        $form = $this->get('adbuyback.form.form_builder.buyback_message')->getForm()->createView();

        try {
            $chat = $this->getQueryBus()->handle(new GetChatForForm($chatId))->getData();
            $messages = $this->getQueryBus()->handle(new GetMessageForChat($chatId))->getData();
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));

            return $this->redirectToRoute('admin_ad_buyback_chat_index');
        }

        return $this->render('@Modules/ad_buyback/views/templates/admin/buyback_chat/view.html.twig', [
            'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
            'chat' => $chat,
            'messages' => $messages,
            'form' => $form
        ]);
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request): RedirectResponse
    {
        $chatId = (int)$request->get('chatId');

        try {
            $this->getCommandBus()->handle(new DeleteBuyBackChatCommand($chatId));
            $this->addFlash('success', $this->trans('Chat has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_chat_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param int $chatId
     * @return JsonResponse
     */
    public function activeAction(int $chatId): JsonResponse
    {
        try {
            $this->getCommandBus()->handle(new ActiveBuyBackChatCommand($chatId));

            $response = [
                'status' => true,
                'message' => $this->trans('The chat status has been successfully updated.', 'Modules.Adbuyback.Alert'),
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
        $chatIds = $request->request->get('buybackChat_bulk_action');

        try {
            $this->getCommandBus()->handle(new DuplicateBulkBuyBackChatCommand($chatIds));
            $this->addFlash('success', $this->trans('The selection has been successfully duplicated.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_chat_index');
    }

    /**
     * @AdminSecurity("is_granted('update', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function activeBulkAction(Request $request): RedirectResponse
    {
        $chatIds = $request->request->get('buybackChat_bulk_action');
        $status = (bool)$request->get('status');

        try {
            $this->getCommandBus()->handle(new ActiveBulkBuyBackChatCommand($chatIds, $status));
            $this->addFlash('success', $status
                ? $this->trans('The selection has been successfully enabled.', 'Modules.Adbuyback.Alert')
                : $this->trans('The selection has been successfully disabled.', 'Modules.Adbuyback.Alert')
            );
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_chat_index');
    }

    /**
     * @AdminSecurity("is_granted('delete', request.get('_legacy_controller'))", message="Access denied.")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteBulkAction(Request $request): RedirectResponse
    {
        $chatIds = $request->request->get('buybackChat_bulk_action');

        try {
            $this->getCommandBus()->handle(new DeleteBulkBuyBackChatCommand($chatIds));
            $this->addFlash('success', $this->trans('The selection has been successfully deleted.', 'Modules.Adbuyback.Alert'));
        } catch (BuyBackException $exception) {
            $this->addFlash('error', $this->trans($exception->getMessage(), 'Modules.Adbuyback.Alert'));
        }

        return $this->redirectToRoute('admin_ad_buyback_chat_index');
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
                'href' => $this->generateUrl('admin_ad_buyback_chat_create'),
                'desc' => $this->trans('New chat', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-success',
                'icon' => 'add_circle_outline'
            ],
            'messages' => [
                'href' => $this->generateUrl('admin_ad_buyback_message_index'),
                'desc' => $this->trans('View all messages', 'Modules.Adbuyback.Admin'),
                'class' => 'btn-info',
                'icon' => 'list'
            ]
        ];
    }
}
