<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Entity\AvailabilitySplitSlots;
use App\Form\AvailabilityType;
use App\Repository\AvailabilityRepository;
use App\Repository\AvailabilitySplitSlotsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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

    #[Route('/availability/show', name: 'app_availability_show')]
    public function show(AvailabilityRepository $availabilityRepository): Response
    {
        $recurringAvailabilities = $availabilityRepository->getRecurringAvailabilitiesByHealthProfessional($this->getUser());
        $exceptionalAvailabilities = $availabilityRepository->getFuturNoneRecurringAvailabilitiesByHealthProfessional($this->getUser());
        return $this->render('availability/showAll.html.twig', [
            'recurringAvailabilities' => $recurringAvailabilities,
            'exceptionalAvailabilities' => $exceptionalAvailabilities,
        ]);
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
                if ($availability->getEndTime() <= $availability->getStartTime()) {
                    $this->addFlash('error', 'L\'heure de fin ne peut pas être avant ou égale à l\'heure de début.');
                    return $this->redirectToRoute('app_availability_create');
                }
                $this->createAvailabilitySplitSlots($availability, $entityManager);
                $entityManager->flush();
                return $this->redirectToRoute('app_availability_show');
            } catch (Exception) {
                echo 'Erreur de création de la disponibilité';
            }
        }
        return $this->render('availability/create.html.twig', [
            'form' => $form,
            'recurrenceType' => $availability->getRecurrenceType(),
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
                if ($availability->getEndTime() <= $availability->getStartTime()) {
                    $this->addFlash('error', 'L\'heure de fin ne peut pas être avant ou égale à l\'heure de début.');
                    return $this->redirectToRoute('app_availability_update');
                }
                if ($availability->getRecurrenceType() !== null) {
                    $this->createAvailabilitySplitSlots($availability, $entityManager);
                }
                $entityManager->flush();
                return $this->redirectToRoute('app_availability_show');
            } catch (Exception) {
                echo 'Erreur de modification de la disponibilité';
            }
        }

        return $this->render('availability/update.html.twig', [
            'form' => $form,
            'recurrenceType' => $availability->getRecurrenceType(),
        ]);
    }

    #[Route('/availability/{id}/delete/{type}', name: 'app_availability_delete', requirements: ['id' => '\d+', 'type' => '\d+'])]
    public function delete(
        int $type,
        int $id,
        EntityManagerInterface $entityManager,
        Request $request,
        AvailabilityRepository $availabilityRepository,
        AvailabilitySplitSlotsRepository $availabilitySplitSlotsRepository
    ): Response {
        // Si type vaut 0, c'est une Availability, sinon c'est une Avai labilitySplitSlots
        if (!$type) {
            $entity = $availabilityRepository->findOneBy(['id' => $id]);
        } else {
            $entity = $availabilitySplitSlotsRepository->findOneBy(['id' => $id]);
        }
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($entity);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_availability_show', ['id' => $entity->getId()]);
        }
        return $this->render('availability/delete.html.twig', [
            'form' => $form,
        ]);
    }

    private function createAvailabilitySplitSlots(Availability $availability, EntityManagerInterface $entityManager): void
    {
        $availability->setIsRecurring((bool)$availability->getRecurrenceType());
        $entityManager->persist($availability);
        $startTime = $availability->getStartTime();
        $endTime = $availability->getEndTime();
        $date = $availability->getDate();
        while ($startTime < $endTime) {
            $nextStartTime = (clone $startTime)->modify('+30 minute');
            $newAvailability = new AvailabilitySplitSlots();
            $newAvailability->setAvailability($availability)
                ->setDate($date)
                ->setStartTime($startTime)
                ->setEndTime($nextStartTime);
            dump($newAvailability);
            $entityManager->persist($newAvailability);
            $startTime = $nextStartTime;
        }
    }
}
