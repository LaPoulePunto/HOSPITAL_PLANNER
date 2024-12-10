<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
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
