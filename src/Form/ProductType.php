<?php

namespace App\Form;

use App\Entity\Price;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('mainImage', FileType::class, ['mapped' => false, 'required' => false, 'data_class' => null])
            ->add('images', FileType::class, ['mapped' => false, 'multiple' => true, 'required' => false])
            ->add('isOnSale')
            ->add('isTop')
            ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Product $product */
            $product = $event->getData();
            $form = $event->getForm();

            $form->add('currentPrice', NumberType::class, ['data' => $product->getCurrentPrice(), 'mapped' => false]);
            $form->add('salePrice', NumberType::class, ['data' => $product->getCurrentSalePrice(), 'mapped' => false]);

        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var Product $product */
            $product = $event->getData();
            $form = $event->getForm();

            foreach ($product->getPrice() as $pr) {
                $pr->setIsCurrent(false);
                $pr->setIsSale(false);
            }

            $currentPrice = new Price();
            $currentPrice->setValue($form->get('currentPrice')->getData());
            $currentPrice->setIsCurrent(true);
            $currentPrice->setIsSale(false);
            $product->addPrice($currentPrice);

            $salePrice = new Price();
            $salePrice->setValue($form->get('salePrice')->getData());
            $salePrice->setIsSale(true);
            $salePrice->setIsCurrent(false);
            $product->addPrice($salePrice);
        });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
