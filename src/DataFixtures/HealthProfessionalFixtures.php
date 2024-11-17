<?php

namespace App\DataFixtures;

use App\Factory\HealthProfessionalFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HealthProfessionalFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        HealthProfessionalFactory::createMany(10);
    }
}
