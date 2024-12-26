<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_HEALTH_PROFESSIONAL')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(): Response
    {
        return $this->render('availability/index.html.twig');
    }

    #[Route('/availability/create', name: 'app_availability_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $availability = new Availability();
        $availability->setHealthprofessional($this->getUser());
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($availability);
                $entityManager->flush();

            } catch (\Exception) {
                echo 'Erreur de création de la disponibilité';
            }
        }
        return $this->render('availability/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/availability/{id}/update', name: 'app_availability_update')]
    public function update(Availability $availability, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($availability->getHealthprofessional() !== $this->getUser()) {
            throw new AccessDeniedHttpException('Ces disponibilités ne sont pas les vôtres');
        }

        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();
            } catch (\Exception) {
                echo 'Erreur de modification de la disponibilité';
            }
        }

        return $this->render('availability/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/availability/{id}/delete', name: 'app_availability_delete')]
    public function delete(Availability $availability, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($availability);
                $entityManager->flush();
            }
        }
        return $this->render('availability/delete.html.twig', [
            'form' => $form,
        ]);

    }
}
