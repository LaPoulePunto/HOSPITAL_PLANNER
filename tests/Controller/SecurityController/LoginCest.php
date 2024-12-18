<?php

namespace App\Tests\Controller\SecurityController;

use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class LoginCest
{
    public function _before(ControllerTester $I): void
    {
        PatientFactory::createOne([
            'email' => 'test@example.com',
        ]);
    }

    public function loginWithValidCredential(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();

        $I->submitForm('form[name="login_form"]', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $I->seeInCurrentUrl('/');
        $I->seeResponseCodeIsSuccessful();
    }

    public function loginWithInvalidCredential(ControllerTester $I)
    {
        $I->amOnPage('/login');
        $I->seeResponseCodeIsSuccessful();

        $I->submitForm('form[name="login_form"]', [
            'email' => 'test@example.com',
            'password' => 'wrongPassword',
        ]);

        $I->seeInCurrentUrl('/');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Identifiants invalides.', '.alert-danger');
    }
}
