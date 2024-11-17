<?php

namespace App\Controller;

use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthProfessionalController extends AbstractController
{
    #[Route('/health/professional', name: 'app_health_professional')]
    public function index(): Response
    {
        return $this->render('health_professional/index.html.twig', [
            'controller_name' => 'HealthProfessionalController',
        ]);
    }

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
}
