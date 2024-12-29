<?php

namespace App\Tests\Controller\Registration;

use App\Entity\User;
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
        $I->seeCurrentRouteIs('app_home');
    }

    public function successfulRegister(ControllerTester $I): void
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();

        $I->selectOption('registration_form[gender]', '1');
        $I->checkOption('registration_form[agreeTerms]');

        $I->fillField('registration_form[email]', 'test@example.com');
        $I->fillField('registration_form[plainPassword][first]', 'Password');
        $I->fillField('registration_form[plainPassword][second]', 'Password');
        $I->fillField('registration_form[firstname]', 'Tom');
        $I->fillField('registration_form[lastname]', 'Mairet');
        $I->fillField('registration_form[birthDate]', '2000-01-01');
        $I->fillField('registration_form[city]', 'Reims');
        $I->fillField('registration_form[postCode]', '51100');
        $I->fillField('registration_form[street]', '2 chemin des Rouliers');
        $I->fillField('registration_form[phone]', '0601020304');

        $I->selectOption('registration_form[gender]', '1');
        $I->checkOption('registration_form[agreeTerms]');

        $I->click('Créer le compte');

        $I->seeInCurrentUrl('/');
        $I->seeInRepository(User::class, ['email' => 'test@example.com']);
    }

    public function registerWithInvalidData(ControllerTester $I): void
    {
        $I->amOnPage('/register');
        $I->seeResponseCodeIsSuccessful();

        $I->fillField('registration_form[email]', 'invalid@email');
        $I->fillField('registration_form[plainPassword][first]', 'Password');
        $I->fillField('registration_form[plainPassword][second]', 'wrongPassword');
        $I->fillField('registration_form[firstname]', 'Oscar');
        $I->fillField('registration_form[lastname]', 'Nerveux');
        $I->fillField('registration_form[birthDate]', '9999-01-01');
        $I->fillField('registration_form[city]', 'Reims');
        $I->fillField('registration_form[postCode]', '51100');
        $I->fillField('registration_form[street]', '2 chemin des Rouliers');
        $I->fillField('registration_form[phone]', '00777');

        $I->selectOption('registration_form[gender]', '1');
        $I->checkOption('registration_form[agreeTerms]');

        $I->click('Créer le compte');

        $I->seeCurrentRouteIs('app_register');

        $I->see('L\'email "invalid@email" n\'est pas valide.', '.invalid-feedback');
        $I->see('Les mots de passe doivent correspondre.', '.invalid-feedback');
        $I->see('Veuillez entrer une date valide.', '.invalid-feedback');
        $I->see('Format de téléphone invalide', '.invalid-feedback');
    }
}
