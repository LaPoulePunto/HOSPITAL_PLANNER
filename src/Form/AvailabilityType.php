<?php

namespace App\Form;

use App\Entity\Availability;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'widget' => 'choice',
                'input' => 'datetime',
                'hours' => range(0, 23),
                'minutes' => [0, 30],
                'attr' => ['class' => 'timepicker'],
            ])
            ->add('endTime', TimeType::class, [
                'widget' => 'choice',
                'input' => 'datetime',
                'hours' => range(0, 23),
                'minutes' => [0, 30],
                'attr' => ['class' => 'timepicker'],
            ])
            ->add('recurrenceType', ChoiceType::class, [
                'choices' => [
                    'Aucune' => null,
                    'Toutes les semaines' => 1,
                    'Touts les mois' => 2,
                    'Tous les ans' => 3,
                ],
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
