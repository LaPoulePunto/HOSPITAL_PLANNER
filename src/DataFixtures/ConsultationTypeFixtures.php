<?php

namespace App\DataFixtures;

use App\Factory\ConsultationTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConsultationTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $content = json_decode(
            file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ConsultationType.json'), true);
        foreach ($content as $type) {
            ConsultationTypeFactory::createOne($type);
        }
    }
}
