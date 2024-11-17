<?php

namespace App\DataFixtures;

use App\Factory\PatientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PatientFactory::createMany(10);
    }
}
