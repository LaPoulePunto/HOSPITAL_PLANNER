<?php

namespace App\DataFixtures;

use App\Entity\ConsultationType;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Entity\Room;
use App\Factory\ConsultationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConsultationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $room = $manager->getRepository(Room::class)->find(rand(1, 10));
            $consultationType = $manager->getRepository(ConsultationType::class)->findAll();
            $consultationType = $consultationType[array_rand($consultationType)];

            $patient = $manager->getRepository(Patient::class)->find(rand(1, 10));
            $consultation = ConsultationFactory::createOne([
                'room' => $room,
                'consultationType' => $consultationType,
                'patient' => $patient
            ])->_real();
            $healthProfessionalArray = $manager->getRepository(HealthProfessional::class)->findAll();
            $healthProfessional = $healthProfessionalArray[array_rand($healthProfessionalArray)];

            $consultation->addHealthProfessional($healthProfessional);
            $manager->persist($consultation);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RoomFixtures::class,
            ConsultationTypeFixtures::class,
            PatientFixtures::class,
            HealthProfessionalFixtures::class,
        ];
    }
}
