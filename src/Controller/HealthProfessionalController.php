<?php

namespace App\Controller;

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
}
