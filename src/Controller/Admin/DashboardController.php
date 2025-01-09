<?php

namespace App\Controller\Admin;

use App\Entity\Availability;
use App\Entity\Consultation;
use App\Entity\ConsultationType;
use App\Entity\Material;
use App\Entity\Patient;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\RoomType;
use App\Entity\Speciality;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 Real 01');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Patient', 'fas fa-user', Patient::class);
        yield MenuItem::linkToCrud('RoomType', 'fas fa-list', RoomType::class);
        yield MenuItem::linkToCrud('Room', 'fas fa-list', Room::class);
        yield MenuItem::linkToCrud('Material', 'fas fa-list', Material::class);
        yield MenuItem::linkToCrud('Speciality', 'fas fa-list', Speciality::class);
        yield MenuItem::linkToCrud('Reservation', 'fas fa-list', Reservation::class);
        yield MenuItem::linkToCrud('Consultation Type', 'fas fa-list', ConsultationType::class);
        yield MenuItem::linkToCrud('Consultation', 'fas fa-list', Consultation::class);
        yield MenuItem::linkToCrud('Availability', 'fas fa-list', Availability::class);
    }
}
