<?php

namespace App\Controller;

use App\Entity\Consultation;
use DateTime;
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

    #[IsGranted('ROLE_HEALTH_PROFESSIONAL')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    #[Route('/consultation/prescription/{id}', name: 'app_consultation_prescription', requirements: ['id' => '\d+'])]
    public function prescription(
        Consultation $consultation,
        Request $request,
        EntityManagerInterface $entityManager
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
        $date = new DateTime();
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
