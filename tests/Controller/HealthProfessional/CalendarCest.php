<?php

namespace App\Tests\Functional;

use App\Factory\ConsultationFactory;
use App\Factory\ConsultationTypeFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Factory\RoomFactory;
use App\Factory\RoomTypeFactory;
use App\Tests\Support\ControllerTester;

class HealthProfessionalCalendarCest
{
    public function _before(ControllerTester $I)
    {
        $healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $I->amLoggedInAs($healthProfessional);

        $startTime = new \DateTime();
        $startTime->setTime(9, 0);
        $endTime = clone $startTime;
        $endTime->modify('+1 hour');

        $roomType = RoomTypeFactory::createOne([
            'label' => 'Salle de Radiologie',
        ])->_real();

        $room = RoomFactory::createOne([
            'floor' => 0,
            'num' => 10,
            'roomtype' => $roomType,
        ])->_real();

        $consultationType = ConsultationTypeFactory::createOne([
            'label' => 'Kinésithérapie',
        ])->_real();

        $patient = PatientFactory::createOne([
            'lastname' => 'Martin',
            'firstname' => 'Thibault',
        ])->_real();

        $consultation = ConsultationFactory::createOne([
            'date' => new \DateTime('2013-05-23'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'room' => $room,
            'consultationType' => $consultationType,
            'patient' => $patient,
        ])->_real();

        $consultation->addHealthprofessional($healthProfessional);
        $entityManager = $I->grabService('doctrine.orm.entity_manager');

        $entityManager->persist($consultation);
        $entityManager->persist($healthProfessional);
        $entityManager->persist($room);
        $entityManager->persist($roomType);
        $entityManager->persist($consultationType);
        $entityManager->persist($patient);
        $entityManager->flush();
    }

    public function TryToTest(ControllerTester $I): void
    {
        $I->amOnPage('/health-professional/calendar');
        $I->seeResponseCodeIs(200);
        $I->see('Page de calendrier');
    }

    public function CalendarDisplaysAppointments(ControllerTester $I): void
    {
        $I->amOnPage('/health-professional/calendar');
        $I->seeInSource("title: 'PATIENT : MARTIN Thibault | TYPE : Kinésithérapie | SALLE : 10 | ÉTAGE : 0 | TYPE DE SALLE : Salle de Radiologie'");
        $I->seeInSource("start: '2013-05-23T09:00:00'");
        $I->seeInSource("end: '2013-05-23T10:00:00'");
    }
}
