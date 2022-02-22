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

namespace AdBuyBack\Form;

use PrestaShopBundle\Form\Admin\Type\SwitchType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class BuyBackType extends TranslatorAwareType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_buyback', HiddenType::class)
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
            ->add('description', TextareaType::class, [
                'label' => $this->trans('Description', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 255])
                ],
                'attr' => [
                    'placeholder' => $this->trans('Description of your products', 'Modules.Adbuyback.Form')
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
            ->add('active', SwitchType::class, [
                'label' => $this->trans('Buy back status', 'Modules.Adbuyback.Form'),
                'choices' => [
                    'OFF' => false,
                    'ON' => true
                ],
            ]);
    }
}
