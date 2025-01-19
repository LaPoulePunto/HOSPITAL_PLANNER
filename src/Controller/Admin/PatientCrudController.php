<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureFields(string $pageName): iterable
    {
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
            TextField::new('city', 'Ville')
                ->setHelp('La ville ne peut pas dépasser 32 caractères.'),
            IntegerField::new('postCode', 'Code postal'),
            TextField::new('phone', 'Téléphone')
                ->setHelp('Format attendu : +33 X XX XX XX XX ou 0X XX XX XX XX.'),
            TextField::new('street', 'Rue')
                ->setHelp('L\'adresse ne peut pas dépasser 128 caractères.'),
            ChoiceField::new('bloodGroup', 'Groupe sanguin')
                ->setChoices([
                    'A+' => 'A+',
                    'A-' => 'A-',
                    'B+' => 'B+',
                    'B-' => 'B-',
                    'AB+' => 'AB+',
                    'AB-' => 'AB-',
                    'O+' => 'O+',
                    'O-' => 'O-',
                ])
                ->setHelp('Sélectionnez le groupe sanguin du patient.'),
            TextareaField::new('allergies', 'Allergies')
                ->hideOnIndex(),
            TextareaField::new('comments', 'Commentaires')
                ->hideOnIndex(),
            TextareaField::new('treatments', 'Traitements')
                ->hideOnIndex(),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Patient' => 'ROLE_PATIENT',
                    'Utilisateur' => 'ROLE_USER',
                ])
                ->allowMultipleChoices(true)
                ->setFormTypeOption('expanded', true)
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('data', ['ROLE_PATIENT', 'ROLE_USER'])
                ->setFormTypeOption('constraints', [
                    new \Symfony\Component\Validator\Constraints\Callback(function ($roles, $context) {
                        if (count($roles) > 2) {
                            $context->buildViolation('Vous ne pouvez sélectionner que 2 rôles maximum.')
                                ->addViolation();
                        }
                        if (!in_array('ROLE_PATIENT', $roles, true) || !in_array('ROLE_USER', $roles, true)) {
                            $context->buildViolation('Les rôles "Patient" et "Utilisateur" sont obligatoires.')
                                ->addViolation();
                        }
                    }),
                ])
                ->formatValue(function ($roles) {
                    $roleLabels = [
                        'ROLE_PATIENT' => 'Patient',
                        'ROLE_USER' => 'Utilisateur',
                    ];

                    return implode(', ', array_map(fn ($role) => $roleLabels[$role] ?? $role, $roles));
                })->hideOnIndex(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function setUserPassword($entityInstance): void
    {
        $request = $this->getContext()->getRequest();

        $formData = $request->request->all();
        $submittedPassword = $formData['Patient']['plainPassword'] ?? null;

        if (!empty($submittedPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $submittedPassword);
            $entityInstance->setPassword($hashedPassword);
        }
    }
}
