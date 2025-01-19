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
    public function homeUser(
        #[CurrentUser]
        #[MapEntity(disabled: true)]
        User $user,
        ConsultationRepository $consultationRepository,
    ): Response {
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('home/user_home.html.twig', [
            'user' => $user,
            'consultations' => $consultationRepository->findConsultationByPatientPastOrFuturReservation($user, true),
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

    #[Route('/conditions-generales', name: 'app_cgu')]
    public function generalConditionsOfUse(): Response
    {
        return $this->render('home/cgu.html.twig');
    }

    #[Route('/a-propos', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('home/about_us.html.twig');
    }

    #[Route('/politiques-confidentialite', name: 'app_privacy_policies')]
    public function privacyPolities(): Response
    {
        return $this->render('home/privacy_policies.html.twig');
    }
}
