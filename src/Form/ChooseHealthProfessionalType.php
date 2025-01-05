<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseHealthProfessionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $healthProfessionals = $options['health_professionals'];
        $builder
            ->add('healthProfessional', EntityType::class, [
                'class' => HealthProfessional::class,
                'choices' => $healthProfessionals,
                'choice_label' => function (HealthProfessional $hp) {
                    return $hp->getLastname().' '.$hp->getFirstname();
                },
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
            'health_professionals' => null,
        ]);
    }
}
