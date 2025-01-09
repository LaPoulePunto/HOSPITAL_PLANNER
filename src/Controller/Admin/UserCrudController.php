<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('login', 'Identifiant'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom de famille'),
            EmailField::new('email', 'Mail'),
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
            Field::new('birthDate', 'Date de naissance'),
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
                }),
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

    public function configureAssets(Assets $assets): Assets
    {
        return parent::configureAssets($assets)
            ->addCssFile(
                'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined'
            );
    }

    /**
     * @param $entityInstance
     * @return void
     */
    public function setUserPassword($entityInstance): void
    {
        $request = $this->getContext()->getRequest();

        $formData = $request->request->all();
        $submittedPassword = $formData['User']['plainPassword'] ?? null;

        if (!empty($submittedPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $submittedPassword);
            $entityInstance->setPassword($hashedPassword);
        }
    }


}
