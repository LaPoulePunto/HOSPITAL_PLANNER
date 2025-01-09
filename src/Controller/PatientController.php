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

    #[Route('/patient/appointment', name: 'app_user_appointments')]
    public function appointment(ConsultationRepository $consultationRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $futurAppointments = $consultationRepository->findConsultationByPatientPastOrFuturReservation($user, true);
        $pastAppointments = $consultationRepository->findConsultationByPatientPastOrFuturReservation($user, false);

        return $this->render('patient/appointment.html.twig', [
            'futurAppointments' => $futurAppointments,
            'pastAppointments' => $pastAppointments,
        ]);
    }
}
