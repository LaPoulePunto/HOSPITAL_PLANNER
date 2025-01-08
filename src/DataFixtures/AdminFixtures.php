<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\UserFactory;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'firstname' =>'Valentin',
            'lastname' =>'Portier',
            'email' => 'admin@gmail.com',
            'roles'=>['ROLE_ADMIN'],
            ]);
        $manager->flush();
    }
}
