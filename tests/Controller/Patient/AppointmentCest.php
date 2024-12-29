<?php

namespace App\Tests\Controller\Patient;

use App\Entity\HealthProfessional;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class AppointmentCest
{
    private object $patient;

    public function _before(ControllerTester $I)
    {
        $this->patient = PatientFactory::createOne()->_real();

        ConsultationFactory::createSequence([
            ['date' => new \DateTime('1924-12-01'), 'startTime' => new \DateTime('09:00:00'), 'endTime' => new \DateTime('10:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('1924-12-02'), 'startTime' => new \DateTime('10:00:00'), 'endTime' => new \DateTime('11:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('1924-12-03'), 'startTime' => new \DateTime('11:00:00'), 'endTime' => new \DateTime('12:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('1924-12-04'), 'startTime' => new \DateTime('14:00:00'), 'endTime' => new \DateTime('15:00:00'), 'patient' => $this->patient],

            ['date' => new \DateTime('2124-12-01'), 'startTime' => new \DateTime('09:00:00'), 'endTime' => new \DateTime('10:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('2124-12-02'), 'startTime' => new \DateTime('10:00:00'), 'endTime' => new \DateTime('11:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('2124-12-03'), 'startTime' => new \DateTime('11:00:00'), 'endTime' => new \DateTime('12:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('2124-12-04'), 'startTime' => new \DateTime('14:00:00'), 'endTime' => new \DateTime('15:00:00'), 'patient' => $this->patient],
            ['date' => new \DateTime('2124-12-05'), 'startTime' => new \DateTime('16:00:00'), 'endTime' => new \DateTime('17:00:00'), 'patient' => $this->patient],
        ]);
    }

    public function testRequiresAuthentication(ControllerTester $I)
    {
        $I->amOnPage('/patient/appointment');
        $I->seeCurrentRouteIs('app_login');
    }

    public function testRequiresPatientRole(ControllerTester $I)
    {
        $patient = HealthProfessionalFactory::createOne()->_real();
        $I->amLoggedInAs($patient);
        $I->amOnPage('/patient/appointment');
        $I->seeResponseCodeIs(403);
    }

    public function testDisplaysFutureConsultations(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage('/patient/appointment');
        $I->see('01/12/2124');
        $I->see('02/12/2124');
        $I->see('03/12/2124');
        $I->see('04/12/2124');
        $I->see('05/12/2124');
    }

    public function testDisplaysPastConsultations(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage('/patient/appointment');
        $I->see('01/12/1924');
        $I->see('02/12/1924');
        $I->see('03/12/1924');
        $I->see('04/12/1924');

    }
}
