<?php

namespace App\Tests\Controller\AvailabilitySplitSlots;

use App\Entity\HealthProfessional;
use App\Factory\AvailabilityFactory;
use App\Factory\AvailabilitySplitSlotsFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;
use DateTime;
use Zenstruck\Foundry\Persistence\Proxy;

class ShowCest
{
    private Proxy|HealthProfessional $healthProfessional;

    public function _before(ControllerTester $I)
    {
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $entityManager = $I->grabService('doctrine.orm.entity_manager');

        $availabilityExceptional = AvailabilityFactory::createOne([
            'date' => new DateTime('2034-12-29'),
            'startTime' => new DateTime('2034-12-29 12:00'),
            'endTime' => new DateTime('2034-12-29 12:30'),
            'recurrenceType' => null,
        ])->_real();

        $availabilityRecurring = AvailabilityFactory::createOne([
            'date' => new DateTime('2027-12-17'),
            'startTime' => new DateTime('2027-12-17 10:00'),
            'endTime' => new DateTime('2027-12-17 11:00'),
            'recurrenceType' => 1,
        ])->_real();

        $availabilitySplitSlots1 = AvailabilitySplitSlotsFactory::createOne([
            'date' => new DateTime('2027-12-17'),
            'startTime' => new DateTime('2027-12-17 10:00'),
            'endTime' => new DateTime('2027-12-17 10:30'),
            'availability' => $availabilityRecurring,
        ])->_real();

        $availabilitySplitSlots2 = AvailabilitySplitSlotsFactory::createOne([
            'date' => new DateTime('2027-12-17'),
            'startTime' => new DateTime('2027-12-17 10:30'),
            'endTime' => new DateTime('2027-12-17 11:00'),
            'availability' => $availabilityRecurring,
        ])->_real();

        $availabilitySplitSlots3 = AvailabilitySplitSlotsFactory::createOne([
            'date' => new DateTime('2034-12-29'),
            'startTime' => new DateTime('2034-12-29 12:00'),
            'endTime' => new DateTime('2034-12-29 12:30'),
            'availability' => $availabilityExceptional,
        ])->_real();

        $availabilityRecurring->addAvailabilitySplitSlot($availabilitySplitSlots1);
        $availabilityRecurring->addAvailabilitySplitSlot($availabilitySplitSlots2);
        $availabilityExceptional->addAvailabilitySplitSlot($availabilitySplitSlots3);
        $this->healthProfessional->addAvailability($availabilityRecurring);
        $this->healthProfessional->addAvailability($availabilityExceptional);

        $entityManager->persist($availabilityRecurring);
        $entityManager->persist($availabilityExceptional);
        $entityManager->persist($availabilitySplitSlots1);
        $entityManager->persist($availabilitySplitSlots2);
        $entityManager->persist($availabilitySplitSlots3);
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

    public function seeNumberOfAvailabilityIsGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');
        $I->seeNumberOfElements('tr.rowAvailability', 2);
    }

    public function seeNumberOfAvailabilitySplitSlotIsGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');
        $I->seeNumberOfElements('ul>li.elementAvailabilitySplitSlots', 3);
    }

    public function seeElementAreGood(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/availability/show');

        $I->see('vendredi 17 décembre 2027', '.rowAvailability');
        $I->see('10:00', '.rowAvailability');
        $I->see('11:00', '.rowAvailability');
        $I->see('10:00 - 10:30', 'ul>li.elementAvailabilitySplitSlots');
        $I->see('10:30 - 11:00', 'ul>li.elementAvailabilitySplitSlots');

        $I->see('vendredi 29 décembre 2034', '.rowAvailability');
        $I->see('12:00 - 12:30', 'ul>li.elementAvailabilitySplitSlots');
        $I->see('12:00', '.rowAvailability');
        $I->see('12:30', '.rowAvailability');
    }
}
