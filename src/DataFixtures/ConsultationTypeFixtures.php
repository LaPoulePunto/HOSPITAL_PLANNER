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
            $roomTypeArray = $manager->getRepository(RoomType::class)->findAll();
            $specialityArray = $manager->getRepository(Speciality::class)->findAll();

            $roomType = $roomTypeArray[array_rand($roomTypeArray)];
            $speciality = $specialityArray[array_rand($specialityArray)];

            ConsultationTypeFactory::createOne([
                'label' => $type['label'],
                'speciality' => $speciality,
                'roomType' => $roomType,
            ]);
        }
    }
}
