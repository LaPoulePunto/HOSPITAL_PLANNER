<?php

namespace App\Tests\Controller\Consultation;

use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class PrescriptionCest
{
    private object $healthProfessional;

    public function _before(ControllerTester $I)
    {
        $consultation1 = ConsultationFactory::createOne()->_real();
        $consultation2 = ConsultationFactory::createOne()->_real();
        $this->healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $consultation1->addHealthProfessional($this->healthProfessional);

        $entityManager = $I->grabService('doctrine.orm.entity_manager');
        $entityManager->persist($consultation1);
        $entityManager->persist($consultation2);
        $entityManager->persist($this->healthProfessional);
        $entityManager->flush();
    }

    public function testPageConnection(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/consultation/prescription/1');
        $I->seeResponseCodeIs(200);
    }

    public function testRequiresAuthentication(ControllerTester $I)
    {
        $I->amOnPage('/consultation/prescription/1');
        $I->seeCurrentRouteIs('app_login');
    }

    public function testRequiresHealthProfessionalRole(ControllerTester $I)
    {
        $patient = PatientFactory::createOne()->_real();
        $I->amLoggedInAs($patient);
        $I->amOnPage('/consultation/prescription/1');
        $I->seeResponseCodeIs(403);
    }

    public function testFormElementsExist(ControllerTester $I)
    {
        $I->amLoggedInAs($this->healthProfessional);
        $I->amOnPage('/consultation/prescription/1');
        $I->seeElement('#signatureCanvas');
        $I->seeElement('input[name="signature"]');
        $I->seeElement('button.signature-button');
    }
}
