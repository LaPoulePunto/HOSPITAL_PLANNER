<?php

namespace App\Tests\Controller\Registration;

use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class RegisterCest
{
    public function accessIsRestrictedToConnectedUsers(ControllerTester $I): void
    {
        $user = PatientFactory::createOne([
            'email' => 'root@example.com',
        ]);
        $realUser = $user->_real();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('/');
    }
}
