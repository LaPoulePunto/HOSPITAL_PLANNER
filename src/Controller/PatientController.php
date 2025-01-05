<?php

namespace App\Controller;

use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_PATIENT')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig');
    }

    #[Route('/patient/consultation', name: 'app_user_consultations')]
    public function consultation(ConsultationRepository $consultationRepository): Response
    {
        $user = $this->getUser();
        $futurConsultations = $consultationRepository->findConsultationByPatientPastOrFuturReservation($user, true);
        $pastConsultations = $consultationRepository->findConsultationByPatientPastOrFuturReservation($user, false);

        return $this->render('patient/consultation.html.twig', [
            'futurConsultations' => $futurConsultations,
            'pastConsultations' => $pastConsultations,
        ]);
    }
}
