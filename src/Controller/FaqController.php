<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(): Response
    {
        $faqData = json_decode(file_get_contents(__DIR__.'/../../assets/data/faq.json'), true);

        return $this->render('faq/index.html.twig', [
            'faqData' => $faqData['questions'],
        ]);
    }
}
