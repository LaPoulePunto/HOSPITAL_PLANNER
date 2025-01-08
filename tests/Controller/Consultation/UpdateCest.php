<?php

namespace App\Tests\Controller\Consultation;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
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
        $I->selectOption('consultation_form[date][day]', '16');
        $I->selectOption('consultation_form[date][month]', '5');
        $I->selectOption('consultation_form[date][year]', '2025');

        // Soumettre le formulaire
        $I->click('input[type=submit][value=Modification]');

        // Vérifier la redirection et la modification
        $I->seeCurrentRouteIs('app_health_professional_calendar');
        $I->seeInRepository(Consultation::class, [
            'id' => $this->consultation->getId(),
            'date' => '2025-05-16',
        ]);
    }
}
