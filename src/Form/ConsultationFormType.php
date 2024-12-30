<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\HealthProfessional;
use App\Entity\Material;
use App\Entity\Patient;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationFormType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $builder
            ->add('date')
            ->add('startTime')
            ->add('endTime')
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'id',
            ])
            ->add('consultationType', EntityType::class, [
                'class' => ConsultationType::class,
                'choice_label' => 'label',
            ]);
        if (in_array('ROLE_HEALTH_PROFESSIONAL', $user->getRoles())) {
            $builder
                ->add('patient', EntityType::class, [
                    'class' => Patient::class,
                    'choice_label' => function (Patient $p) {
                        return $p->getLastname() . ' ' . $p->getFirstname();
                    },
                    'multiple' => true,
                ]);
        } elseif (in_array('ROLE_PATIENT', $user->getRoles())) {
            $builder
                ->add('healthProfessional', EntityType::class, [
                    'class' => HealthProfessional::class,
                    'choice_label' => function (HealthProfessional $hp) {
                        return $hp->getLastname() . ' ' . $hp->getFirstname();
                    },
                    'multiple' => true,
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
