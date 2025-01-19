<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('startTime', 'Début'),
            Field::new('endTime', 'Fin'),
            AssociationField::new('material', 'Matériel')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', function ($material) {
                    return $material ? $material->getLabel() : '';
                })
                ->formatValue(function ($value) {
                    return $value ? $value->getLabel() : '';
                }),
            AssociationField::new('healthProfessional', 'Professionnels de santé')
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', function ($healthProfessional) {
                    return $healthProfessional ? $healthProfessional->getFullName() : '';
                })
                ->formatValue(function ($value) {
                    return $value ? $value->getFullName() : null;
                }),
        ];
    }
}
