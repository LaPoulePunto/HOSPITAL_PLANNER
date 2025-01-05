<?php


namespace App\Tests\Controller\Consultation;

use App\Factory\ConsultationFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $consultation = ConsultationFactory::createOne()->_real();
        $I->amOnPage("/consultation/{$consultation->getId()}/update");
        $I->seeCurrentRouteIs('app_login');
    }
}
