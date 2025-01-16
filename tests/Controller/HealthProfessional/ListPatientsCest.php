<?php

namespace App\Tests\Controller\HealthProfessional;

use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;
use PHPUnit\Framework\Assert;

class ListPatientsCest
{
    public function _before(ControllerTester $I)
    {
        $healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $I->amLoggedInAs($healthProfessional);

        $patient1 = PatientFactory::createOne([
            'lastname' => 'Granger',
            'firstname' => 'Hermione',
            'gender' => 0,
        ])->_real();

        $patient2 = PatientFactory::createOne([
            'lastname' => 'Weasley',
            'firstname' => 'Ron',
            'gender' => 1,
        ])->_real();

        $patient3 = PatientFactory::createOne([
            'lastname' => 'Potter',
            'firstname' => 'Harry',
            'gender' => 1,
        ])->_real();

        $consultations = ConsultationFactory::createSequence([
            ['patient' => $patient1],
            ['patient' => $patient2],
            ['patient' => $patient3],
        ]);

        $entityManager = $I->grabService('doctrine.orm.entity_manager');

        foreach ($consultations as $consultation) {
            $consultation = $consultation->_real();
            $consultation->addHealthProfessional($healthProfessional);
            $entityManager->persist($consultation);
        }

        $entityManager->flush();
    }

    // tests
    public function PatientsAreSortedTest(ControllerTester $I)
    {
        $I->amOnPage('/health-professional/list-patients');
        $I->seeResponseCodeIsSuccessful();
        $actualOrder = $I->grabMultiple('a.list-group-item-action');
        $expectedOrder = [
            'Mme Granger, Hermione',
            'M. Potter, Harry',
            'M. Weasley, Ron',
        ];
        Assert::assertEquals($expectedOrder, $actualOrder);
    }
}
