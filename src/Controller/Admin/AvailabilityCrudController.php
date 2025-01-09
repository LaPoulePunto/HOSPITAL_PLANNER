<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class AvailabilityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Availability::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('date', 'Date'),
            TimeField::new('startTime', 'Début'),
            TimeField::new('endTime', 'Fin'),

            ChoiceField::new('recurrenceType', 'Type de récurrence')
                ->setChoices([
                    'Aucune' => 0,
                    'Toutes les semaines' => 1,
                    'Tous les mois' => 2,
                    'Tous les ans' => 3,
                ])
                ->renderExpanded(false),

            AssociationField::new('healthProfessional', 'Professionnel de santé')
                ->setFormTypeOptions([
                    'choice_label' => function ($healthProfessional) {
                        return $healthProfessional ? $healthProfessional->getFullName() : '';
                    },
                ])
                ->formatValue(function ($value, $entity) {
                    return $entity->getHealthProfessional() ?
                        $entity->getHealthProfessional()->getFullName() : 'Aucun';
                }),
        ];
    }
}
