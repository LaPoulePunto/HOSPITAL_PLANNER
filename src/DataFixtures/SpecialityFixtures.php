<?php

namespace App\DataFixtures;

use App\Factory\SpecialityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $content = json_decode(
            file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'Speciality.json'),
            true
        );
        foreach ($content as $type) {
            SpecialityFactory::createOne($type);
        }
    }
}
