<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use App\Entity\User;
use App\Entity\Review;
use App\Entity\Contact;
use App\Entity\Service;
use App\Entity\Employee;
use App\Entity\Equipment;
use App\Entity\Newsletter;
use App\Entity\PhotoRoom;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="../assets/img/logo-welcome.svg"> Hotello Resort - Admin')
            ->setFaviconPath('favicon.ico')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fas fa-hotel');
        yield MenuItem::linkToCrud('Clients', 'fas fa-user-group', User::class);
        yield MenuItem::linkToCrud('Chambres', 'fas fa-bed', Room::class);
        yield MenuItem::linkToCrud('Photos chambres', 'fa-solid fa-camera-retro', PhotoRoom::class);
        yield MenuItem::linkToCrud('Équipements', 'fas fa-bath', Equipment::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-bell-concierge', Service::class);
        yield MenuItem::linkToCrud('Employés', 'fas fa-circle-user', Employee::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-inbox', Contact::class);
        yield MenuItem::linkToCrud('Avis', 'fas fa-comments', Review::class);
        yield MenuItem::linkToCrud('Newsletter', 'fa-regular fa-newspaper', Newsletter::class);
    }

    public function configureAssets(): Assets
    {
        return Assets::new()->addCssFile('css/admin.css');
    }
}
