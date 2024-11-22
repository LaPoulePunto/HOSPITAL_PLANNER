<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Factory\MaterialFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MaterialFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $rooms = $manager->getRepository(Room::class)->findAll();
        foreach ($rooms as $room) {
            $nbMaterial = random_int(0, 4);
            for ($i = 0; $i < $nbMaterial; $i++) {
                MaterialFactory::createOne(['room' => $room]);
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            RoomFixtures::class,
        ];
    }
}
