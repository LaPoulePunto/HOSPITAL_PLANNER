<?php

namespace App\Controller;

use App\Repository\ConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig');
    }

    #[Route('/user/appointment', name: 'app_user_show')]
    public function appointment(ConsultationRepository $consultationRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $futurAppointments = $consultationRepository->findByPatientPastOrFuturReservation($user, true);
        $pastAppointments = $consultationRepository->findByPatientPastOrFuturReservation($user, false);

        return $this->render('patient/appointment.html.twig', [
            'futurAppointments' => $futurAppointments,
            'pastAppointments' => $pastAppointments,
        ]);
    }
}
