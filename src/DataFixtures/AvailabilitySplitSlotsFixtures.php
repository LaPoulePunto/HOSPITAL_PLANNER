<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\AvailabilitySplitSlots;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AvailabilitySplitSlotsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $availabilities = $manager->getRepository(Availability::class)->findAll();
        foreach ($availabilities as $availability) {
            $this->createAvailabilitySplitSlots($availability, $manager);
        }
        $manager->flush();
    }

    private function createAvailabilitySplitSlots(Availability $availability, ObjectManager $entityManager): void
    {
        $startTime = $availability->getStartTime();
        $endTime = $availability->getEndTime();
        $date = $availability->getDate();

        while ($startTime < $endTime) {
            $nextStartTime = (clone $startTime)->modify('+30 minutes');
            $newSlot = new AvailabilitySplitSlots();
            $newSlot->setAvailability($availability)
                ->setDate($date)
                ->setStartTime($startTime)
                ->setEndTime($nextStartTime);

            $entityManager->persist($newSlot);
            $startTime = $nextStartTime;
        }
    }

    public function getDependencies(): array
    {
        return [AvailabilityFixtures::class];
    }
}
