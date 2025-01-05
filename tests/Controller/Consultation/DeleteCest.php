<?php


namespace App\Tests\Controller\Consultation;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    private Patient $patient;
    private HealthProfessional  $healthProfessional;

    public function _before(ControllerTester $I)
    {
        $this->patient = PatientFactory::createOne()->_real();
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        ConsultationFactory::createOne();
    }

    public function testRedirectToLoginIfNotAuthenticated(ControllerTester $I)
    {
        $consultation = ConsultationFactory::createOne()->_real();
        $I->amOnPage("/consultation/{$consultation->getId()}/delete");
        $I->seeCurrentRouteIs('app_login');
    }

    public function deleteAsAPatient(ControllerTester $I)
    {
        $consultation = ConsultationFactory::createOne()->_real();
        $I->amLoggedInAs($this->patient);
        $I->amOnPage("/consultation/{$consultation->getId()}/delete");

        $I->seeCurrentRouteIs('app_user_consultations');

        $I->dontSeeInRepository(Consultation::class, ['id' => $consultation->getId()]);
    }

    public function deleteAsAHealthProfessional(ControllerTester $I)
    {
        $consultation = ConsultationFactory::createOne()->_real();
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage("/consultation/{$consultation->getId()}/delete");

        $I->seeCurrentRouteIs('app_health_professional_calendar');

        $I->dontSeeInRepository(Consultation::class, ['id' => $consultation->getId()]);
    }
}