<?php

namespace App\DataFixtures;

use App\Entity\HealthProfessional;
use App\Entity\Material;
use App\Factory\ReservationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ReservationFactory::createMany(
            10,
            static function () use ($manager) {
                $healthProfessionalArray = $manager->getRepository(HealthProfessional::class)->findAll();
                $healthProfessional = $healthProfessionalArray[array_rand($healthProfessionalArray)];
                $material = $manager->getRepository(Material::class)->find(rand(1, 15));

                return ['healthprofessional' => $healthProfessional, 'material' => $material];
            }
        );
    }

    public function getDependencies(): array
    {
        return [
            HealthProfessionalFixtures::class,
            MaterialFixtures::class,
        ];
    }
}
