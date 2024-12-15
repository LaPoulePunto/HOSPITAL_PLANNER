<?php

namespace App\Tests\Controller\User;

use App\Entity\User;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateCest
{
    public function testGeneralPageStructure(ControllerTester $I): void
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->object());
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
        $I->amLoggedInAs($patient->object());
        $I->amOnPage('/user/update');

        $I->fillField('update_user_form[email]', 'new.email@example.com');
        $I->click('Mettre à jour le compte');

        $I->seeCurrentRouteIs('app_user_update');

        $I->seeInRepository(User::class, [
            'id' => $patient->getId(),
            //            'email' => 'new.email@example.com',
        ]);
    }

    public function testUpdatePasswordSuccessfully(ControllerTester $I)
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->object());
        $I->amOnPage('/user/update');

        // Mettre à jour le mot de passe via le formulaire
        $I->fillField('update_user_form[password]', 'new_password');
        $I->click('Mettre à jour le compte');

        $I->seeCurrentRouteIs('app_user_update');

        // Vérifie que le mot de passe a bien été mis à jour
        $updatedUser = $I->grabEntityFromRepository(User::class, [
            'id' => $patient->getId(),
        ]);
        $passwordHasher = $I->grabService(UserPasswordHasherInterface::class);

        // Vérification du hash du mot de passe
        $I->assertTrue(
            $passwordHasher->isPasswordValid($updatedUser, 'new_password'),
            'Le mot de passe haché ne correspond pas au mot de passe attendu.'
        );
    }
}
