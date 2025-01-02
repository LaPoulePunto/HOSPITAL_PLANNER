<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ConsultationRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/home', name: 'app_home_user')]
    public function homePatient(
        #[CurrentUser]
        #[MapEntity(disabled: true)]
        User $user,
        ConsultationRepository $consultationRepository,
    ): Response {
        return $this->render('home/user_home.html.twig', [
            'user' => $user,
            'consultations' => $consultationRepository->getAllConsultationsByUser($user),
        ]);
    }

    #[Route('/welcome', name: 'app_home_session')]
    public function sessionChoice(): Response
    {
        return $this->render('home/session.html.twig');
    }

    #[Route('/contact-page', name: 'app_contact_page')]
    public function contact_page(): Response
    {
        return $this->render('contact_page/index.html.twig', [
            'controller_name' => 'ContactPageController',
        ]);
    }
}
