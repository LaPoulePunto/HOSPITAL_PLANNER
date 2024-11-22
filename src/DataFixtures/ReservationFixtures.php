<?php

namespace App\DataFixtures;

use App\Entity\HealthProfessional;
use App\Entity\Material;
use App\Factory\ReservationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ReservationFactory::createMany(
            10,
            static function () use ($manager) {
                $healthprofessional = $manager->getRepository(HealthProfessional::class)->find(rand(1, 10));
                $material = $manager->getRepository(Material::class)->find(rand(1, 15));

                return ['healthprofessional' => $healthprofessional, 'material' => $material];
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
