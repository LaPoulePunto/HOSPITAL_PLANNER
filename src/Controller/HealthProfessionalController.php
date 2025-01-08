<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConsultationRepository;
use App\Repository\PatientRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_HEALTH_PROFESSIONAL')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class HealthProfessionalController extends AbstractController
{
    #[Route('/health-professional/patient-file/{patientId}', name: 'app_display_patient_file', requirements: ['patientId' => '\d+'])]
    public function displayPatientFile(PatientRepository $patientRepository, int $patientId): Response
    {
        $patient = $patientRepository->getPatientById($patientId);

        return $this->render('health_professional/display_patient_file.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/health-professional/calendar', name: 'app_health_professional_calendar')]
    public function showCalendar(
        ConsultationRepository $consultationRepository,
        #[CurrentUser]
        #[MapEntity(disabled: true)]
        User $healthProfessional,
    ): Response {
        $appointments = $consultationRepository->getAllConsultationsByUser($healthProfessional);

        return $this->render('health_professional/calendar.html.twig', [
            'appointments' => $appointments ?? null,
        ]);
    }

    #[Route('/health-professional/list_patients', name: 'app_health_professional_patients')]
    public function listPatients(
        PatientRepository $patientRepository,
        #[CurrentUser]
        User $healthProfessional,
    ): Response {
        $patients = $patientRepository->findPatientsByHealthProfessional($healthProfessional);

        return $this->render('health_professional/list_patients.html.twig', [
            'patients' => $patients,
        ]);
    }
}
