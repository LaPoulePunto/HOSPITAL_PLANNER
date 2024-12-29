<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\Patient;
use App\Form\ConsultationFormType;
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

    #[Route('/consultation/appointment/create', name: 'create_medical_appointment', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_PATIENT')]
    public function createMedicalAppointment(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = $this->getUser();

        if (!$patient) {
            throw $this->createNotFoundException('Le patient demandé n\'existe pas.');
        }
        $appointment = new Consultation();
        $appointment->setPatient($patient);

        $form = $this->createForm(ConsultationFormType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appointment);
            $entityManager->flush();


            return $this->redirectToRoute('app_user_appointments');
        }

        return $this->render('consultation/create_medical_appointment.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
        ]);
    }

    #[Route('/consultation/appointment/update', name: 'update_medical_appointment')]
    #[IsGranted('ROLE_PATIENT')]
    public function updateMedicalAppointment(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = $this->getUser();

        if (!$patient instanceof Patient) {
            throw $this->createAccessDeniedException('Vous devez être un patient pour modifier une consultation.');
        }

        $consultation = $entityManager->getRepository(Consultation::class)->findOneBy([
            'patient' => $patient,
        ]);

        if (!$consultation) {
            throw $this->createNotFoundException('Aucune consultation à modifier trouvée pour ce patient.');
        }

        $form = $this->createForm(ConsultationFormType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La consultation a été mise à jour avec succès.');
            return $this->redirectToRoute('app_user_appointments');
        }

        return $this->render('consultation/update_medical_appointment.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
        ]);
    }


    #[Route('/consultation/appointment/{id}/delete', name: 'delete_medical_appointment', requirements: ['id' => '\d+'])]
    public function deleteMedicalAppointment(Patient $patient): Response
    {
        return $this->render('consultation/delete_medical_appointment.html.twig', [
            'patient' => $patient,
        ]);
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
