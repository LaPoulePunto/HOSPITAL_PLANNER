<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConsultationRepository;
use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_HEALTH_PROFESSIONAL')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class HealthProfessionalController extends AbstractController
{
    #[Route('/health-professional/consultation/{consultationId}', name: 'app_display_patient_file')]
    public function displayPatientFile(ConsultationRepository $consultationRepository, int $consultationId): Response
    {
        $consultation = $consultationRepository->getConsultationById($consultationId);
        if (!$consultation) {
            throw $this->createNotFoundException("Aucune consultation trouvée pour l'ID spécifié.");
        }

        $patient = $consultation->getPatient();
        if (!$patient) {
            throw $this->createNotFoundException("Aucun patient n'est associé à cette consultation.");
        }

        return $this->render('health_professional/display_patient_file.html.twig', ['patient' => $patient]);
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
    public function listPatients(PatientRepository $patientRepository): Response
    {
        $user = $this->getUser();

        if (!$user || !$this->isGranted('ROLE_HEALTH_PROFESSIONAL')) {
            throw $this->createAccessDeniedException('Accès refusé. Vous devez être un professionnel de santé.');
        }

        $patients = $patientRepository->findPatientsByHealthProfessional($user->getId());


        return $this->render('health_professional/list_patients.html.twig', [
            'patients' => $patients,
        ]);
    }

}
