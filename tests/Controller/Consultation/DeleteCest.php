<?php


namespace App\Tests\Controller\Consultation;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $consultation = ConsultationFactory::createOne()->_real();
        $I->amOnPage("/consultation/{$consultation->getId()}/delete");
        $I->seeCurrentRouteIs('app_login');
    }
}
