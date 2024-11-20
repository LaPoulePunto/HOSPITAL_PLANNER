<?php

namespace App\DataFixtures;

use App\Entity\ConsultationType;
use App\Entity\Patient;
use App\Entity\Room;
use App\Factory\ConsultationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Consultation extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ConsultationFactory::createMany(10,
            static function () use ($manager) {
                $room = $manager->getRepository(Room::class)->find(rand(1, 10));
                $consType = $manager->getRepository(ConsultationType::class)->find(rand(1, 10));
                $patient = $manager->getRepository(Patient::class)->find(rand(1, 10));
                return ['room' => $room, 'consultationtype' => $consType, 'patient' => $patient];
            });
    }

    public function getDependencies(): array
    {
        return [
            RoomFixtures::class,
            ConsultationTypeFixtures::class,
            PatientFixtures::class,
        ];
    }
}
