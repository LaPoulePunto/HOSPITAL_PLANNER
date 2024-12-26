<?php

namespace App\Form;

use App\Entity\Availability;
use App\Entity\HealthProfessional;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d'),
                ]
            ])
            ->add('startTime', TimeType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('endTime', TimeType::class, [
                'widget' => 'single_text',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}
