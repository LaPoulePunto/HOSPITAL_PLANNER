<?php

namespace App\Tests\Controller\HealthProfessional;

use App\Factory\ConsultationFactory;
use App\Factory\HealthProfessionalFactory;
use App\Factory\PatientFactory;
use App\Tests\Support\ControllerTester;

class DisplayPatientFileCest
{
    private object $patient;

    public function _before(ControllerTester $I)
    {
        $healthProfessional = HealthProfessionalFactory::createOne()->_real();
        $I->amLoggedInAs($healthProfessional);

        $healthProfessional1 = HealthProfessionalFactory::createOne([
            'lastname' => 'McGonagall',
            'firstname' => 'Minerva',
            'job' => 'Kinésithérapeute',
        ])->_real();

        $healthProfessional2 = HealthProfessionalFactory::createOne([
            'lastname' => 'Ombrage',
            'firstname' => 'Dolores',
            'job' => 'Chirurgien',
        ])->_real();

        $healthProfessional3 = HealthProfessionalFactory::createOne([
            'lastname' => 'Rogue',
            'firstname' => 'Severus',
            'job' => 'Médecin Généraliste',
        ])->_real();

        $this->patient = PatientFactory::createOne([
            'lastname' => 'Dumbledore',
            'firstname' => 'Albus',
            'birthdate' => new \DateTime('1881-01-01'),
            'bloodGroup' => 'A+',
            'allergies' => 'Arachide',
            'treatments' => null,
            'comments' => null,
        ])->_real();

        $consultation1 = ConsultationFactory::createOne([
            'patient' => $this->patient,
            'date' => new \DateTime('1930-12-01'),
        ])->_real();

        $consultation2 = ConsultationFactory::createOne([
            'patient' => $this->patient,
            'date' => new \DateTime('1940-12-01'),
        ])->_real();

        $consultation3 = ConsultationFactory::createOne([
            'patient' => $this->patient,
            'date' => new \DateTime('2030-12-01'),
        ])->_real();

        $consultation1->addHealthProfessional($healthProfessional1);
        $consultation2->addHealthProfessional($healthProfessional2);
        $consultation3->addHealthProfessional($healthProfessional3);
        $entityManager = $I->grabService('doctrine.orm.entity_manager');
        $entityManager->persist($consultation1);
        $entityManager->persist($consultation2);
        $entityManager->persist($consultation3);
        $entityManager->flush();
    }

    // tests
    public function testPatientFileDisplaysCorrectly(ControllerTester $I)
    {
        $I->amOnPage('/health-professional/patient-file/'.$this->patient->getId());
        $I->seeResponseCodeIsSuccessful();
        $I->see('Dumbledore Albus');
        $I->see('Date de naissance : 01/01/1881');
        $I->see('Groupe sanguin : A+');
        $I->see('Allergies : Arachide');
        $I->see('Traitements suivis : Pas de traitement renseigné');
        $I->see('Commentaires : Pas de commentaire laissé');
    }
}
