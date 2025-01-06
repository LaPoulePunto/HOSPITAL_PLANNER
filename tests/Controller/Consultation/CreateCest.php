<?php

namespace App\Tests\Controller\Consultation;

use App\Entity\ConsultationType;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Factory\ConsultationTypeFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Factory\RoomFactory;
use App\Tests\Support\ControllerTester;

class CreateCest
{
    private Patient $patient;
    private HealthProfessional $healthProfessional;
    private ConsultationType $consultationType;

    public function _before(ControllerTester $I)
    {
        $this->patient = PatientFactory::createOne()->_real();
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $this->consultationType = ConsultationTypeFactory::createOne()->_real();
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $I->amOnPage('/consultation/create');
        $I->seeCurrentRouteIs('app_login');
    }

    public function createConsultationAsPatient(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage('/consultation/create');
        $I->seeResponseCodeIsSuccessful();

        // Choisir la date
        $I->selectOption('consultation_form[date][day]', '15');
        $I->selectOption('consultation_form[date][month]', '5');
        $I->selectOption('consultation_form[date][year]', '2025');

        // Heure de début
        $I->selectOption('consultation_form[startTime][hour]', '10');
        $I->selectOption('consultation_form[startTime][minute]', '30');

        // Heure de fin
        $I->selectOption('consultation_form[endTime][hour]', '11');
        $I->selectOption('consultation_form[endTime][minute]', '30');

        // Type de consultation
        $I->selectOption('consultation_form[consultationType]', $this->consultationType->getLabel());

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Création]');

        // Vérifier la redirection
        $I->seeCurrentRouteIs('app_consultation_select_health_professional');
    }

    public function createConsultationAsHealthProfessional(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        RoomFactory::createOne();
        $I->amOnPage('/consultation/create');
        $I->seeResponseCodeIsSuccessful();

        // Sélectionner la date de consultation
        $I->selectOption('consultation_form[date][day]', '15');
        $I->selectOption('consultation_form[date][month]', '5');
        $I->selectOption('consultation_form[date][year]', '2025');

        // Sélectionner l'heure de début
        $I->selectOption('consultation_form[startTime][hour]', '10');
        $I->selectOption('consultation_form[startTime][minute]', '30');

        // Sélectionner l'heure de fin
        $I->selectOption('consultation_form[endTime][hour]', '11');
        $I->selectOption('consultation_form[endTime][minute]', '30');

        // Choisir le type de consultation
        $I->selectOption('consultation_form[consultationType]', '1');

        // Sélectionner le patient
        $I->selectOption('consultation_form[patient]', '1');

        // Choisir la salle de consultation
        $I->selectOption('consultation_form[room]', '1');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Création]');

        // Vérifier la redirection
        $I->seeCurrentRouteIs('app_health_professional_calendar');
    }
}
