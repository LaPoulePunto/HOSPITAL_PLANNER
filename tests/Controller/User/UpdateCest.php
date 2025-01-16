<?php

namespace App\Tests\Controller\User;

use App\Entity\User;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateCest
{
    public function testGeneralPageStructure(ControllerTester $I): void
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->_real());
        $I->amOnPage('/user/update');
        $I->seeCurrentRouteIs('app_user_update');

        // Vérifie la présence des éléments principaux
        $I->see("Édition du compte de {$patient->getLastname()}, {$patient->getFirstname()}", 'h1');
        $I->seeElement('form');
        $I->seeElement('input', ['name' => 'update_user_form[password]']);
        $I->seeElement('input', ['name' => 'update_user_form[email]']);
        $I->see('Mettre à jour le compte', 'button[type="submit"]');
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $I->amOnPage('/user/update');
        $I->seeCurrentRouteIs('app_login');
    }

    public function testUpdateEmailSuccessfully(ControllerTester $I)
    {
        $patient = PatientFactory::createOne(['email' => 'old.email@example.com']);
        $I->amLoggedInAs($patient->_real());
        $I->amOnPage('/user/update');

        $I->fillField('update_user_form[email]', 'new.email@example.com');
        $I->click('Mettre à jour le compte');

        $I->seeCurrentRouteIs('app_user_update');

        $I->seeInRepository(User::class, [
            'id' => $patient->getId(),
            'email' => 'new.email@example.com',
        ]);
    }

    public function testUpdatePasswordSuccessfully(ControllerTester $I)
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->_real());
        $I->amOnPage('/user/update');

        $I->fillField('update_user_form[password]', 'new_password');
        $I->click('Mettre à jour le compte');

        $I->seeCurrentRouteIs('app_user_update');

        $updatedUser = $I->grabEntityFromRepository(User::class, [
            'id' => $patient->getId(),
        ]);
        $passwordHasher = $I->grabService(UserPasswordHasherInterface::class);

        $I->assertTrue(
            $passwordHasher->isPasswordValid($updatedUser, 'new_password'),
            'Le mot de passe haché ne correspond pas au mot de passe attendu.'
        );
    }

    public function testUpdateName(ControllerTester $I)
    {
        $patient = PatientFactory::createOne([
            'firstName' => 'Jérôme',
            'lastname' => 'Cutrona',
        ]);
        $I->amLoggedInAs($patient->_real());
        $I->amOnPage('/user/update');

        $I->fillField('update_user_form[firstname]', 'Didier');
        $I->fillField('update_user_form[lastname]', 'Gillard');
        $I->click('Mettre à jour le compte');
        $I->seeInRepository(User::class, [
            'id' => $patient->getId(),
            'firstname' => 'Didier',
            'lastname' => 'Gillard',
        ]);
    }

    public function testHealthProfessionalCannotUpdateAccount(ControllerTester $I): void
    {
        $healthProfessional = HealthProfessionalFactory::createOne(['email' => 'health.pro@example.com']);
        $I->amLoggedInAs($healthProfessional->_real());
        $I->amOnPage('/user/update');
        $I->seeCurrentRouteIs('app_home');
    }
}
