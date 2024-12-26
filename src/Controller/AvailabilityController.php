<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
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

    #[Route('/availability/create', name: 'app_availability_create')]
    public function create(): Response
    {
        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);

        return $this->render('availability/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/availability/{id}/update', name: 'app_availability_update')]
    public function update(Availability $availability): Response
    {
        $form = $this->createForm(AvailabilityType::class, $availability);

        return $this->render('availability/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/availability/{id}/delete', name: 'app_availability_delete')]
    public function delete(): Response
    {
        return $this->render('delete/index.html.twig');
    }
}
