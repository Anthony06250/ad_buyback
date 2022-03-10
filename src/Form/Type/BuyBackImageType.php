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
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use PrestaShopException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

final class BuyBackImageType extends TranslatorAwareType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     * @throws PrestaShopException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_ad_buyback_image', HiddenType::class)
            ->add('id_ad_buyback', ChoiceType::class, [
                'label' => $this->trans('Buyback', 'Modules.Adbuyback.Form'),
                'required' => true,
                'choices' => BuyBack::getBuyBacksList()
            ])
            ->add('image', FileType::class, [
                'label' => $this->trans('Upload image', 'Modules.Adbuyback.Form'),
                'required' => true,
                'attr' => [
                    'placeholder' => $this->trans('Upload images of your products', 'Modules.Adbuyback.Form')
                ]
            ])
            ->add('name', TextType::class, [
                'label' => $this->trans('Image name', 'Modules.Adbuyback.Form'),
                'required' => true,
                'constraints' => [
                    new Length(['max' => 128])
                ],
                'attr' => [
                    'placeholder' => $this->trans('The image name', 'Modules.Adbuyback.Form')
                ]
            ]);
    }
}
