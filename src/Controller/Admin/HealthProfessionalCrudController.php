<?php

namespace App\Controller\Admin;

use App\Entity\HealthProfessional;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HealthProfessionalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HealthProfessional::class;
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
            DateField::new('hiringDate', 'Date d\'embauche')->setRequired(false),
            DateField::new('departureDate', 'Date de départ')->setRequired(false),
            TextField::new('job', 'Métier'),
        ];
    }

}
