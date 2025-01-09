<?php

namespace App\Tests\Controller\Consultation;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Factory\RoomFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    private Patient $patient;
    private HealthProfessional $healthProfessional;
    private Consultation $consultation;

    public function _before(ControllerTester $I): void
    {
        $this->patient = PatientFactory::createOne()->_real();
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $this->consultation = ConsultationFactory::createOne()
            ->_real()
            ->addHealthprofessional($this->healthProfessional);

        $entityManager = $I->grabService('doctrine.orm.entity_manager');
        $entityManager->persist($this->consultation);
        $entityManager->flush();
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeCurrentRouteIs('app_login');
    }

    public function testUpdateConsultationDateAsHealthProfessional(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeResponseCodeIsSuccessful();

        // Modifier la date
        $I->fillField('consultation_form[date]', '2025-05-16');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_health_professional_calendar');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'date' => '2025-05-16',
        ]);
    }

    public function testUpdateConsultationDateAsPatient(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeResponseCodeIsSuccessful();

        // Modifier la date
        $I->fillField('consultation_form[date]', '2025-05-16');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_user_consultations');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'date' => '2025-05-16',
        ]);
    }

    public function testUpdateConsultationHourAsPatient(ControllerTester $I)
    {
        $I->amLoggedInAs($this->patient);
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeResponseCodeIsSuccessful();

        // Heure de début
        $I->selectOption('consultation_form[startTime][hour]', '10');
        $I->selectOption('consultation_form[startTime][minute]', '30');

        // Heure de fin
        $I->selectOption('consultation_form[endTime][hour]', '11');
        $I->selectOption('consultation_form[endTime][minute]', '30');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_user_consultations');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'startTime' => '10:30:00',
            'endTime' => '11:30:00',
        ]);
    }

    public function testUpdateConsultationHourAshealthProfessional(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeResponseCodeIsSuccessful();

        // Heure de début
        $I->selectOption('consultation_form[startTime][hour]', '10');
        $I->selectOption('consultation_form[startTime][minute]', '30');

        // Heure de fin
        $I->selectOption('consultation_form[endTime][hour]', '11');
        $I->selectOption('consultation_form[endTime][minute]', '30');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_health_professional_calendar');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'startTime' => '10:30:00',
            'endTime' => '11:30:00',
        ]);
    }

    public function testUpdateConsultationRoomAsHealthProfessional(ControllerTester $I)
    {
        $newRoom = RoomFactory::createOne()->_real();

        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage("/consultation/{$this->consultation->getId()}/update");
        $I->seeResponseCodeIsSuccessful();

        // Modifier la salle
        $I->selectOption('consultation_form[room]', "{$newRoom->getId()}");

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_health_professional_calendar');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'room' => "{$newRoom->getId()}",
        ]);
    }
}
