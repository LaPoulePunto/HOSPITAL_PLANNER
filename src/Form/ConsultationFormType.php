<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
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
            ->add('startTime')
            ->add('endTime')
            ->add('consultationType', EntityType::class, [
                'class' => ConsultationType::class,
                'choice_label' => 'label',
            ]);
        if (in_array('ROLE_HEALTH_PROFESSIONAL', $user->getRoles())) {
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
                    'choice_label' => 'id',
                ]);
        } elseif (in_array('ROLE_PATIENT', $user->getRoles())) {
            $healthProfessionals = $this->entityManager->getRepository(HealthProfessional::class)->findBy(['departureDate' => null]);
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
