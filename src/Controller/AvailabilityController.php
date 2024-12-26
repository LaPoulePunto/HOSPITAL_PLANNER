<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(): Response
    {
        return $this->render('availability/index.html.twig');
    }

    #[Route('/availability', name: 'app_availability_create')]
    public function create(): Response
    {
        return $this->render('availability/create.html.twig');
    }

    #[Route('/availability/{id}', name: 'app_availability_update')]
    public function update(): Response
    {
        return $this->render('availability/update.html.twig');
    }

    #[Route('/availability/{id}', name: 'app_availability_delete')]
    public function delete(): Response
    {
        return $this->render('delete/index.html.twig');
    }
}
