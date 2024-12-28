<?php

namespace App\Tests\Controller\AvailabilitySplitSlots;

use App\Factory\AvailabilityFactory;
use App\Factory\AvailabilitySplitSlotsFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class ShowCest
{
    private \Zenstruck\Foundry\Persistence\Proxy|\App\Entity\HealthProfessional $healthProfessional;

    public function _before(ControllerTester $I)
    {
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $entityManager = $I->grabService('doctrine.orm.entity_manager');
        $availabilityExceptional = AvailabilityFactory::createOne([
            'date' => new \DateTime('2034-12-29'),
            'startTime' => new \DateTime('2034-12-29 10:00'),
            'endTime' => new \DateTime('2034-12-29 13:00'),
            'isRecurring' => false,
            'recurrenceType' => null,
        ])->_real();

        $availabilityRecurring = AvailabilityFactory::createOne([
            'date' => new \DateTime('2027-12-17'),
            'startTime' => new \DateTime('2027-12-17 10:00'),
            'endTime' => new \DateTime('2027-12-17 11:00'),
            'isRecurring' => true,
            'recurrenceType' => 1,
        ])->_real();

        $availabilitySplitSlots1 = AvailabilitySplitSlotsFactory::createOne([
            'date' => new \DateTime('2027-12-17'),
            'startTime' => new \DateTime('2027-12-17 10:00'),
            'endTime' => new \DateTime('2027-12-17 10:30'),
            'availability' => $availabilityRecurring,
        ])->_real();

        $availabilitySplitSlots2 = AvailabilitySplitSlotsFactory::createOne([
            'date' => new \DateTime('2027-12-17'),
            'startTime' => new \DateTime('2027-12-17 10:30'),
            'endTime' => new \DateTime('2027-12-17 11:00'),
            'availability' => $availabilityRecurring,
        ])->_real();

        $availabilityRecurring->addAvailabilitySplitSlot($availabilitySplitSlots1);
        $availabilityRecurring->addAvailabilitySplitSlot($availabilitySplitSlots2);
        $this->healthProfessional->addAvailability($availabilityRecurring);
        $this->healthProfessional->addAvailability($availabilityExceptional);

        $entityManager->persist($availabilityRecurring);
        $entityManager->persist($availabilityExceptional);
        $entityManager->persist($availabilitySplitSlots1);
        $entityManager->persist($availabilitySplitSlots2);
        $entityManager->persist($this->healthProfessional);
        $entityManager->flush();
    }


    public function tryToTestWithConnection(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');
        $I->seeResponseCodeIs(200);
    }

    public function tryToTestWithoutConnection(ControllerTester $I)
    {
        $I->amOnPage('/availability/show');
        $I->seeCurrentRouteIs('app_login');
    }

    public function tryToTestWithoutRoles(ControllerTester $I)
    {
        $I->amLoggedInAs(PatientFactory::createOne()->_real());
        $I->amOnPage('/availability/show');
        $I->seeResponseCodeIs(403);
    }

    public function seeNumberOfAvailabilyIsGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');
        $I->seeNumberOfElements('tr.rowAvailability', 2);
    }

    public function seeNumberOfAvailabilitySplitSlotIsGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');
        $I->seeNumberOfElements('ul>li.elementAvailabilitySplitSlots', 2);
    }

    public function seeElementAreGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');

        $I->see('vendredi 17 décembre 2027', '.rowAvailability');
        $I->see('10:00', '.rowAvailability');
        $I->see('11:00', '.rowAvailability');

        $I->see('vendredi 29 décembre 2034', '.rowAvailability');
        $I->see('10:00', '.rowAvailability');
        $I->see('13:00', '.rowAvailability');

        $I->see('10:00 - 10:30', 'ul>li.elementAvailabilitySplitSlots');
        $I->see('10:30 - 11:00', 'ul>li.elementAvailabilitySplitSlots');
    }
}
