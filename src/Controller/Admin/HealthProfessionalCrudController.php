<?php

namespace App\Controller\Admin;

use App\Entity\HealthProfessional;
use App\Entity\User;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HealthProfessionalCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;
    private SpecialityRepository $specialityRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, SpecialityRepository $specialityRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->specialityRepository = $specialityRepository;
    }

    public static function getEntityFqcn(): string
    {
        return HealthProfessional::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $specialityChoices = $this->getSpecialityChoices();

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname', 'Prénom')->hideOnIndex(),
            TextField::new('lastname', 'Nom de famille')->hideOnIndex(),
            TextField::new('fullName', 'Nom complet')
                ->setVirtual(true)
                ->formatValue(function ($value, $entity) {
                    if ($entity instanceof User) {
                        return $entity->getFullName();
                    }

                    return 'Inconnu';
                })->hideOnForm(),
            TextField::new('login', 'Identifiant')->hideOnIndex(),
            EmailField::new('email', 'Mail')->hideOnIndex(),
            Field::new('plainPassword', 'Mot de passe')
                ->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'mapped' => false,
                    'empty_data' => '',
                    'attr' => [
                        'autocomplete' => 'new-password',
                    ],
                ]),
            ChoiceField::new('gender', 'Genre')
                ->setChoices([
                    'Homme' => 0,
                    'Femme' => 1,
                ]),
            DateField::new('birthDate', 'Date de naissance'),
            DateField::new('hiringDate', 'Date d\'embauche')->setRequired(false),
            DateField::new('departureDate', 'Date de départ')->setRequired(false),
            ChoiceField::new('job', 'Métier')
                ->setChoices($specialityChoices)
                ->setRequired(true),
            ArrayField::new('roles', 'Role')
                ->formatValue(function (?array $role) {
                    if (in_array('ROLE_ADMIN', $role)) {
                        return '<span class="material-symbols-outlined">shield_person</span>';
                    } elseif (in_array('ROLE_PATIENT', $role)) {
                        return '<span class="material-symbols-outlined">personal_injury</span>';
                    } elseif (in_array('ROLE_HEALTH_PROFESSIONAL', $role)) {
                        return '<span class="material-symbols-outlined">medical_information</span>';
                    }

                    return '';
                })->hideOnIndex(),
        ];
    }

    private function getSpecialityChoices(): array
    {
        $jobs = $this->specialityRepository->findAll();

        $choices = [];
        foreach ($jobs as $job) {
            $choices[$job->getLabel()] = $job->getId();
        }

        return $choices;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setHealthProfessionalPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setHealthProfessionalPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function setHealthProfessionalPassword($entityInstance): void
    {
        $request = $this->getContext()->getRequest();

        $formData = $request->request->all();
        $submittedPassword = $formData['HealthProfessional']['plainPassword'] ?? null;

        if (!empty($submittedPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $submittedPassword);
            $entityInstance->setPassword($hashedPassword);
        }
    }
}
