<?php

namespace App\Tests\Functional;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Tests\Support\ControllerTester;

class HealthProfessionalCalendarCest
{
    private HealthProfessional $healthProfessional;
    private Consultation  $consultation;

    public function _before(ControllerTester $I)
    {
        // Création d'un utilisateur avec une factory
        $this->healthProfessional = HealthProfessionalFactory::createOne([
            'email' => 'test@hp.com',
            'password' => 'password',
        ])->_real();
        $I->amLoggedInAs($this->healthProfessional);

        // Création de la consultation
        $startTime = new \DateTime();
        $startTime->setTime(9, 0);
        $endTime = clone $startTime;
        $endTime->modify('+1 hour');

        $this->consultation = ConsultationFactory::createOne([
            'date' => new \DateTime('2013-05-23'),
            'start_time' => $startTime,
            'end_time' => $endTime,
        ])->_real();

        $this->consultation->addHealthprofessional($this->healthProfessional);

        $entityManager = $I->grabService('doctrine.orm.entity_manager');

        $entityManager->persist($this->consultation);
        $entityManager->persist($this->healthProfessional);
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
        $I->seeInSource("start: '2013-05-23T09:00:00'");
        //        , end: '2013-05-23T10:00:00
    }
}
