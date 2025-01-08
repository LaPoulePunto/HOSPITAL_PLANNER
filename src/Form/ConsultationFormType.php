<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\Patient;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationFormType extends AbstractType
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $builder
            ->add('date')
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
            ->add('consultationType', EntityType::class, [
                'class' => ConsultationType::class,
                'choice_label' => 'label',
            ]);
        if ($this->security->isGranted('ROLE_HEALTH_PROFESSIONAL')) {
            $builder
                ->add('patient', EntityType::class, [
                    'class' => Patient::class,
                    'choice_label' => function (Patient $p) {
                        return $p->getLastname().' '.$p->getFirstname();
                    },
                    'multiple' => false,
                ])
                ->add('room', EntityType::class, [
                    'class' => Room::class,
                    'choice_label' => 'num',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
