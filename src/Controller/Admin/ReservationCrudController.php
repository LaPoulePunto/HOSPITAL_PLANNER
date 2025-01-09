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
            AssociationField::new('material', 'Matériel')->formatValue(function ($value) {
                return $value ? $value->getLabel() : '';
            }),
            AssociationField::new('healthProfessional', 'Professionnel de santé')
                ->formatValue(function ($value) {
                    return $value ? $value->getFullName() : null;
                }),
        ];
    }
}
