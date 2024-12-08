<?php

namespace App\DataFixtures;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Factory\AvailabilityFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AvailabilityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $availabilityDict = [];
        AvailabilityFactory::createMany(
            100,
            static function () use ($manager) {
                $healthProfessionalArray = $manager->getRepository(HealthProfessional::class)->findAll();
                $healthProfessional = $healthProfessionalArray[array_rand($healthProfessionalArray)];
                $healthprofessionalId = $healthProfessional->getId();
                if (!isset($availabilityDict[$healthprofessionalId])) {
                    $availabilityDict[$healthprofessionalId] = $manager->getRepository(Consultation::class)
                        ->getAllConsultationsByHealthProfessionalId($healthprofessionalId);
                }
                $date = null;
                while ($date === null) {
                    $date = new DateTime();
                    $date->modify('+' . rand(0, 29) . ' days')->format('Y-m-d');
                    $startTime = new DateTime();
                    $minutes = [0, 15, 30, 45];
                    $startTime->setTime(rand(8, 20), $minutes[array_rand($minutes)]);
                    $endTime = clone $startTime;
                    $endTime->modify('+30 minutes');
                    // On vérifie à chaque itération qu'il n'y ait pas de chevauchements
                    foreach ($availabilityDict[$healthprofessionalId] as $dateTaken) {
                        // Vérification qu'il n'y a pas de chevauchements
                        if ($dateTaken['date'] === $date
                            &&
                            ($dateTaken['startTime'] >= $startTime && $dateTaken['startTime'] <= $endTime)
                            ||
                           ($dateTaken['endTime'] <= $endTime && $dateTaken['endTime'] >= $startTime)
                            ||
                            ($dateTaken['startTime']) <= $startTime && $dateTaken['endTime'] >= $endTime
                        ) {
                            // S'il y a un chevauchement, on refait un tour de boucle
                            $date = null;
                        }
                    }
                }

                return [
                    'healthprofessional' => $healthProfessional,
                    'date' => $date,
                    'startTime' => $startTime,
                    'endTime' => $endTime
                ];
            }
        );
    }

    public function getDependencies(): array
    {
        return [
            HealthProfessionalFixtures::class
        ];
    }
}
