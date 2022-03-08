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

use AdBuyBack\Model\BuyBack;
use AdBuyBack\Model\BuyBackChat;
use AdBuyBack\Tools\BuyBackTools;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

final class BuyBackMessageType extends TranslatorAwareType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     * @throws PrestaShopException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_buyback_message', HiddenType::class)
            ->add('id_ad_buyback_chat', ChoiceType::class, [
                'label' => $this->trans('Chat', 'Modules.Adbuyback.Form'),
                'required' => true,
                'choices' => BuyBackChat::getBuyBackChatsList(),
                'placeholder' => $this->trans('Choose chat', 'Modules.Adbuyback.Form')
            ])
            ->add('id_customer', ChoiceType::class, [
                'label' => $this->trans('Customer', 'Modules.Adbuyback.Form'),
                'required' => false,
                'choices' => BuyBack::getCustomersList(),
                'placeholder' => $this->trans('Choose customer', 'Modules.Adbuyback.Form')
            ])
            ->add('id_employee', ChoiceType::class, [
                'label' => $this->trans('Employee', 'Modules.Adbuyback.Form'),
                'required' => false,
                'choices' => BuyBackTools::getEmployeesList(),
                'placeholder' => $this->trans('Choose employee', 'Modules.Adbuyback.Form')
            ])
            ->add('message', TextareaType::class, [
                'label' => $this->trans('Message', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 65000])
                ],
                'attr' => [
                    'placeholder' => $this->trans('Your message', 'Modules.Adbuyback.Form'),
                    'rows' => 8
                ]
            ])
            ->add('active', SwitchType::class, [
                'label' => $this->trans('Status', 'Modules.Adbuyback.Form'),
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ]
            ]);
    }
}
