<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }

    #[Route('/consultation/prescription/{id}', name: 'app_consultation_prescription', requirements: ['id' => '\d+'])]
    public function prescription(
        ConsultationRepository $consultationRepository,
        Consultation $consultation,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createFormBuilder()
            ->add('texte', TextareaType::class, [
                'label' => 'Texte de l\'ordonnance',
                'attr' => ['rows' => 10],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $texte = $form->get('texte')->getData();
            $consultation->setPrescription($texte);
            $entityManager->persist($consultation);
            $entityManager->flush();
            return $this->redirectToRoute('app_health_professional_calendar');
        }

        return $this->render('consultation/prescription.html.twig', [
            'form' => $form,
            'consultation' => $consultation,
        ]);
    }
}
