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

namespace AdBuyBack\Form\Type;

use AdBuyBack\Domain\BuyBackChat\Query\GetChatForBuyBack;
use AdBuyBack\Domain\BuyBackImage\Query\GetImageForBuyBack;
use AdBuyBack\Domain\BuyBackMessage\Query\GetMessageForBuyBack;
use AdBuyBack\Tools\BuyBackTools;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Form\Admin\Type\CustomContentType;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Length;

class BuyBackType extends TranslatorAwareType
{
    /**
     * @var CommandBusInterface
     */
    private $queryBus;

    /**
     * @var int
     */
    private $buybackId;

    /**
     * @param TranslatorInterface $translator
     * @param array $locales
     * @param CommandBusInterface $queryBus
     * @param RequestStack $request
     */
    public function __construct(TranslatorInterface $translator, array $locales, CommandBusInterface $queryBus, RequestStack $request)
    {
        parent::__construct($translator, $locales);
        $this->queryBus = $queryBus;
        $request = $request->getCurrentRequest();
        $this->buybackId = $request ? (int)$request->get('buybackId') : null;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_buyback', HiddenType::class)
            ->add('id_customer', HiddenType::class)
            ->add('id_gender', ChoiceType::class, [
                'label' => $this->trans('Civility', 'Modules.Adbuyback.Form'),
                'required' => true,
                'choices' => BuyBackTools::getGendersList(),
                'placeholder' => $this->trans('Your civility', 'Modules.Adbuyback.Form')
            ])
            ->add('firstname', TextType::class, [
                'label' => $this->trans('Firstname', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'placeholder' => $this->trans('Your firstname', 'Modules.Adbuyback.Form')
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => $this->trans('Lastname', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'placeholder' => $this->trans('Your lastname', 'Modules.Adbuyback.Form')
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => $this->trans('Email', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 255]),
                ],
                'attr' => [
                    'placeholder' => $this->trans('Your email', 'Modules.Adbuyback.Form')
                ]
            ])
            ->add('image', FileType::class, [
                'label' => $this->trans('Upload images', 'Modules.Adbuyback.Form'),
                'required' => false,
                'multiple' => true,
                'attr' => [
                    'placeholder' => $this->trans('Upload images of your products', 'Modules.Adbuyback.Form')
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => $this->trans('Message', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'placeholder' => $this->trans('Your message', 'Modules.Adbuyback.Form'),
                    'rows' => 5
                ]
            ])
            ->add('active', SwitchType::class, [
                'label' => $this->trans('Status', 'Modules.Adbuyback.Form'),
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ]
            ]);

        if ($this->buybackId) {
            $this->getBuyBackMessage($builder);
            $this->getBuyBackImage($builder);
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    private function getBuyBackMessage(FormBuilderInterface $builder): void
    {
        $chats = $this->queryBus->handle(new GetChatForBuyBack($this->buybackId))->getData();

        foreach ($chats as $chat) {
            if ($message = $this->queryBus->handle(new GetMessageForBuyBack($chat['id_ad_buyback_chat']))->getData()) {
                $builder->add('message-' . $message['id_ad_buyback_message'], CustomContentType::class, [
                    'required' => false,
                    'template' => '@Modules/ad_buyback/views/templates/admin/buyback/_parts/chat.html.twig',
                    'data' => [
                        'chatId' => $chat['id_ad_buyback_chat'],
                        'message' => [$message],
                    ]
                ]);
            }
        }
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    private function getBuyBackImage(FormBuilderInterface $builder): void
    {
        $images = $this->queryBus->handle(new GetImageForBuyBack($this->buybackId))->getData();
        $directory = 'ad_buyback/views/img/buyback/' . $this->buybackId . '/thumbnail/';

        foreach ($images as $image) {
            if (file_exists(_PS_MODULE_DIR_ . $directory . $image['name'])) {
                $infos = pathinfo(_MODULE_DIR_ . $directory . $image['name']);

                $builder->add('image-' . $image['id_ad_buyback_image'], CustomContentType::class, [
                    'required' => false,
                    'template' => '@Modules/ad_buyback/views/templates/admin/buyback/_parts/image.html.twig',
                    'data' => [
                        'id' => $image['id_ad_buyback_image'],
                        'filename' => $infos['filename'],
                        'extension' => $infos['extension'],
                        'path' => _MODULE_DIR_ . $directory . $image['name'],
                    ]
                ]);
            }
        }
    }
}
