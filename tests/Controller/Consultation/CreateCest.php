<?php


namespace App\Tests\Controller\Consultation;

use App\Tests\Support\ControllerTester;

class CreateCest
{
    public function _before(ControllerTester $I)
    {
    }

    public function createConsultation(ControllerTester $I)
    {
        $I->amOnPage('/consultation/create');
        $I->seeResponseCodeIsSuccessful();
    }
}
