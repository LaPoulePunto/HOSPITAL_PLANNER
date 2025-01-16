<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $floors = $this->entityManager->createQueryBuilder()
            ->select('DISTINCT r.floor')
            ->from(Room::class, 'r')
            ->getQuery()
            ->getResult();

        $floorChoices = [];
        foreach ($floors as $floor) {
            $floorChoices[$floor['floor']] = $floor['floor'];
        }

        return [
            IdField::new('id')->hideOnForm(),
            Field::new('num', 'Numéro'),
            ChoiceField::new('floor', 'Etage')
                ->setChoices($floorChoices)
                ->setRequired(true)
        ];
    }
}
