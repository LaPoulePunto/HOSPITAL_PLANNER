<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactPageController extends AbstractController
{
    #[Route('/contact-page', name: 'app_contact_page')]
    public function index(): Response
    {
        return $this->render('contact_page/index.html.twig', [
            'controller_name' => 'ContactPageController',
        ]);
    }
}
