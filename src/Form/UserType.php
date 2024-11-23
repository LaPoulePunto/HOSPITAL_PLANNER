<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('lastname')
            ->add('firstname')
            ->add('login')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 0,
                    'Femme' => 1,
                ],
                'expanded' => true, // Radio boutons
                'multiple' => false, // Une seule sélection possible
            ])
            ->add('birthDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
