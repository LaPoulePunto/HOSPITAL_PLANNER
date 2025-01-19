<?php

namespace App\DataFixtures;

use App\Factory\PatientFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PatientFactory::createOne([
            'firstname' => 'Ron',
            'lastname' => 'Weasley',
            'email' => 'patient@example.com',
        ]);
        PatientFactory::createMany(3);
    }
}
