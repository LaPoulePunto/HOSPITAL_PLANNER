<?php

namespace App\Tests\Controller\User;

use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $I->amOnPage('/user/delete');
        $I->seeCurrentRouteIs('app_login');
    }

    public function testGeneralPageStructure(ControllerTester $I): void
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->object());
        $I->amOnPage('/user/delete');
        $I->seeCurrentRouteIs('app_user_delete');

        $I->see("Suppression du compte de {$patient->getLastname()}, {$patient->getFirstname()}", 'h1'); // Vérifie si la page de suppression est correcte

        // Vérifie que le formulaire est présent
        $I->seeElement('form');

        // Vérifie les boutons principaux
        $I->see('Supprimer', 'button');
        $I->see('Annuler', 'button');
    }

    public function testCancelDeletion(ControllerTester $I)
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->object());
        $I->amOnPage('/user/delete');
        $I->click('Annuler');
        $I->seeCurrentRouteIs('app_home');

    }

    public function testDeletePatientAccount(ControllerTester $I)
    {
        $patient = PatientFactory::createOne([]);
        $I->amLoggedInAs($patient->object());
        $I->amOnPage('/user/delete');

        $I->click('Supprimer');
        $I->seeCurrentRouteIs('app_home');
        $I->dontSeeInRepository(\App\Entity\Patient::class, ['id' => $patient->getId()]);
    }

    public function testPreventHealthProfessionalDeletion(ControllerTester $I)
    {
        $healthProfessional = HealthProfessionalFactory::createOne([]);
        $I->amLoggedInAs($healthProfessional->object());
        $I->amOnPage('/user/delete');

        $I->click('Supprimer');
        $I->seeCurrentRouteIs('app_home');
        $I->seeInRepository(\App\Entity\HealthProfessional::class, ['id' => $healthProfessional->getId()]);
    }
}
