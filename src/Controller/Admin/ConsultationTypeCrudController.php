<?php

namespace App\Controller\Admin;

use App\Entity\ConsultationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ConsultationTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ConsultationType::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label', 'Nom de type de consultation'),
        ];
    }

}
