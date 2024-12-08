<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use App\Factory\HealthProfessionalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HealthProfessionalFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $healthProfessional = HealthProfessionalFactory::createOne()->_real();
            $specialityArray = $manager->getRepository(Speciality::class)->findBy([]);
            $speciality = $specialityArray[array_rand($specialityArray)];
            $healthProfessional->addSpeciality($speciality);
            $manager->persist($healthProfessional);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SpecialityFixtures::class,
        ];
    }
}
