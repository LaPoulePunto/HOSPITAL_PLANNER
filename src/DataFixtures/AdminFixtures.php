<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'firstname' => 'Valentin',
            'lastname' => 'Portier',
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        $manager->flush();
    }
}
