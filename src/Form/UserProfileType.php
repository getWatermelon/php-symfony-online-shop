<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('name')
//            ->add('roles', ChoiceType::class, [
//                'choices' => [
//                    'Пользователь' => 'ROLE_USER',
//                    'Администратор' => 'ROLE_ADMIN'
//                ],
//                'multiple' => true
//            ])
            ->add('image', FileType::class, ['mapped' => false, 'required' => false, 'data_class' => null])
//            ->add('password')
//            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}