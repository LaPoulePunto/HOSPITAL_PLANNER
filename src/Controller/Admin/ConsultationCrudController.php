<?php

namespace App\Controller\Admin;

use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\Patient;
use App\Entity\Room;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class ConsultationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('date', 'Date'),
            TimeField::new('startTime', 'Début'),
            TimeField::new('endTime', 'Fin'),

            AssociationField::new('room', 'Salle')
                ->setFormTypeOption('choice_label', function ($room) {
                    return $room ? 'Salle '.$room->getNum().' (Étage '.$room->getFloor().')' : '';
                })
                ->formatValue(function (?Room $room) {
                    return $room?->getNum() ?? 'Aucun type de consultation';
                }),

            AssociationField::new('consultationType', 'Type de consultation')
                ->setFormTypeOption('choice_label', function ($consultationType) {
                    return $consultationType ? $consultationType->getLabel() : '';
                })
                ->formatValue(function (?ConsultationType $consultationType) {
                    return $consultationType?->getLabel() ?? 'Aucun type de consultation';
                }),

            AssociationField::new('patient', 'Patient')
                ->setFormTypeOption('choice_label', function ($patient) {
                    return $patient ? $patient->getFullName() : '';
                })->formatValue(function (?Patient $patient) {
                    return $patient ? $patient->getFullName() : 'Aucun patient';
                }),

            AssociationField::new('healthProfessional', 'Professionnels de santé')
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('choice_label', function ($healthProfessional) {
                    return $healthProfessional ? $healthProfessional->getFullName() : '';
                })
                ->formatValue(function (?Collection $healthProfessionals) {
                    if ($healthProfessionals && $healthProfessionals->count() > 0) {
                        return implode(', ', $healthProfessionals->map(fn ($healthProfessional) => $healthProfessional->getFullName())->toArray());
                    }

                    return 'Aucun professionnel de santé';
                }),

            TextareaField::new('prescription', 'Prescription'),

            ImageField::new('signature', 'Signature')
                ->setBasePath('/uploads/signatures')
                ->onlyOnDetail(),
        ];
    }
}
