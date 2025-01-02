<?php

namespace App\DataFixtures;

use App\Entity\RoomType;
use App\Entity\Speciality;
use App\Factory\ConsultationTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ConsultationTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $content = json_decode(
            file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ConsultationType.json'),
            true
        );
        foreach ($content as $type) {

            $roomType = $manager->getRepository(RoomType::class)->find(rand(1, 3));
            $speciality = $manager->getRepository(Speciality::class)->find(rand(1, 4));

            ConsultationTypeFactory::createOne([
                'label' => $type['label'],
                'speciality' => $speciality,
                'roomType' => $roomType,
            ]);
        }
    }
}
