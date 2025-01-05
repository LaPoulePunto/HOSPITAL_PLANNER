<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\HealthProfessional;
use App\Entity\Patient;
use App\Form\ChooseHealthProfessionalType;
use App\Form\ConsultationFormType;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }

    #[Route('/consultation/create', name: 'app_consultation_create')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $consultation = new Consultation();

        if ($this->isGranted('ROLE_PATIENT')) {
            $consultation->setPatient($user);
        } else {
            $consultation->addHealthprofessional($user);
        }

        $form = $this->createForm(ConsultationFormType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('app_consultation_select_health_professional', ['id' => $consultation->getId()]);
        }

        return $this->render('consultation/create.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/consultation/select-health-professional/{id}', name: 'app_consultation_select_health_professional', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_PATIENT')]
    public function chooseHealthProfessional(Consultation $consultation, Request $request, EntityManagerInterface $entityManager): Response
    {
        $healthProfessionals = $entityManager->getRepository(HealthProfessional::class)->getAllHealthProfessionalPossible($consultation->getId());

        $form = $this->createForm(ChooseHealthProfessionalType::class, $consultation, [
            'health_professionals' => $healthProfessionals,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_consultations');
        }

        return $this->render('consultation/select_health_professional.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/consultation/{id}/update', name: 'app_consultation_update')]
    #[IsGranted('ROLE_USER')]
    public function update(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $user = $this->getUser();

        $repository = $entityManager->getRepository(Consultation::class);

        if ($user instanceof Patient) {
            $consultation = $repository->find($id);
        } elseif ($user instanceof HealthProfessional) {
            $query = $repository->createQueryBuilder('c')
                ->innerJoin('c.healthProfessional', 'hp')
                ->where('c.id = :id')
                ->andWhere('hp.id = :userId')
                ->setParameter('id', $id)
                ->setParameter('userId', $user->getId())
                ->getQuery();
            $consultation = $query->getOneOrNullResult();
        } else {
            throw $this->createAccessDeniedException('Accès refusé.');
        }

        if (!$consultation) {
            throw $this->createNotFoundException('Aucune consultation trouvée pour cet ID et cet utilisateur.');
        }

        $form = $this->createForm(ConsultationFormType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            if ($this->isGranted('ROLE_PATIENT')) {
                return $this->redirectToRoute('app_user_consultations');
            }
            return $this->redirectToRoute('app_health_professional_calendar');
        }

        return $this->render('consultation/update.html.twig', [
            'form' => $form,
            'patient' => $user,
        ]);
    }

    #[Route('/consultation/{id}/delete', name: 'app_consultation_delete')]
    #[IsGranted('ROLE_USER')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $consultationRepository = $entityManager->getRepository(Consultation::class);

        $consultation = $consultationRepository->find($id);

        if (!$consultation) {
            throw $this->createNotFoundException('Rendez-vous non trouvé.');
        }

        $entityManager->remove($consultation);
        $entityManager->flush();
        if ($this->isGranted('ROLE_PATIENT')) {
            return $this->redirectToRoute('app_user_consultations');
        }
        return $this->redirectToRoute('app_health_professional_calendar');
    }

    public function isAppointmentConflict(Consultation $consultation): bool
    {
        $appointments = ConsultationRepository::class->findBy([
            'date' => $consultation->getDate()->format('Y-m-d'),
            'room' => $consultation->getRoom(),
        ]);

        $existingStart = $consultation->getStartTime();
        $existingEnd = $appointments->getEndTime();

        foreach ($appointments as $appointment) {
            if (($appointment->getStartTime() > $existingStart) && ($appointment->getEndTime() < $existingEnd)) {
                return true;
            }
        }

        return false;
    }

    #[IsGranted('ROLE_HEALTH_PROFESSIONAL')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    #[Route('/consultation/prescription/{id}', name: 'app_consultation_prescription', requirements: ['id' => '\d+'])]
    public function prescription(
        Consultation $consultation,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        if (!in_array($this->getUser(), $consultation->getHealthprofessional()->toArray())) {
            throw $this->createAccessDeniedException('Ces consultations ne sont pas les vôtres');
        }
        $form = $this->createFormBuilder()
            ->add('prescription', TextareaType::class, [
                'label' => 'Texte de l\'ordonnance',
                'attr' => ['rows' => 10],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prescription = $form->get('prescription')->getData();
            $signature = $request->get('signature');
            $consultation->setSignature($signature);
            $consultation->setPrescription($prescription);
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('app_health_professional_calendar');
        }

        return $this->render('consultation/prescription.html.twig', [
            'form' => $form,
            'consultation' => $consultation,
        ]);
    }

    public function HTMLToPDF(Consultation $consultation): Response
    {
        $date = new \DateTime();
        $html = $this->renderView('consultation/prescription_pdf.html.twig', [
            'date' => $date,
            'consultation' => $consultation,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $pdfContent = $dompdf->output();

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ordonnance.pdf"',
        ]);
    }
}
