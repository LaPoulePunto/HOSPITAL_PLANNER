<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PatientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('fullName', 'Nom complet')
                ->setVirtual(true)
                ->formatValue(function ($value, $entity) {
                    if ($entity instanceof User) {
                        return $entity->getFullName();
                    }

                    return 'Inconnu';
                }),
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
        ];
    }
}
