<?php

namespace App\DataFixtures;

use App\Entity\RoomType;
use App\Factory\RoomFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoomFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $floors = ['RDC' => 0, '1er' => 1, '2e' => 2];
        foreach ($floors as $floor => $number) {
            for ($i = 1; $i < 21; ++$i) {
                RoomFactory::createOne([
                    'roomtype' => $manager->getRepository(RoomType::class)->find(rand(1, 3)),
                    'floor' => $floor,
                    'num' => $number * 100 + $i,
                ]);
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            RoomTypeFixtures::class,
        ];
    }
}
