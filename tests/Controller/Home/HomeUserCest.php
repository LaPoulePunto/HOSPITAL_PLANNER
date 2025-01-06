<?php

namespace App\Tests\Controller\Home;

use App\Factory\HealthProfessionalFactory;
use App\Tests\Support\ControllerTester;

class HomeUserCest
{
    private object $healthProfessional;

    public function _before(ControllerTester $I)
    {
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $this->patient = PatientFactory::createOne()->_real();
    }

    // tests
    public function redirectingToHomeAsHealthProfessional(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/health-professional/calendar');
        $I->seeResponseCodeIsSuccessful();
        $I->click('HOSPITIME');
        $I->seeCurrentRouteIs('app_home_user');
    }

    public function redirectingToHomeAsPatient(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage('/patient/appointment');
        $I->seeResponseCodeIsSuccessful();
        $I->click('HOSPITIME');
        $I->seeCurrentRouteIs('app_home_user');
    }
}
