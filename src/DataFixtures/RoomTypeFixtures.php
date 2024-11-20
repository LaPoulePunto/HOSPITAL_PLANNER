<?php

namespace App\DataFixtures;

use App\Factory\RoomTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoomTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $content = json_decode(
            file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'RoomType.json'), true);
        foreach ($content as $type) {
            RoomTypeFactory::createOne($type);
        }
    }
}
