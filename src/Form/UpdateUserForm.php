<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
            ])
//            ->add('currentPassword', PasswordType::class, [
//                'label' => 'Mot de passe actuel',
//                'mapped' => false,
//                'required' => true,
//            ])
            ->add('password', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'required' => false,
                'empty_data' => '',
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
            ])
            ->add('login', null, [
                'label' => 'Identifiant',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'Homme' => 1,
                    'Femme' => 0,
                ],
                'expanded' => true,
            ])
            ->add('birthDate', null, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ]);
    }
}
