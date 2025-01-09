<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConsultationRepository;
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

        return $this->render('health_professional/displayPatientFile.html.twig', ['patient' => $patient]);
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
}
