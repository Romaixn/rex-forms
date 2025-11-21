<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BookStore Demo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('EasyAdmin Approaches');
        yield MenuItem::linkToCrud('1. Getter/Setter', 'fas fa-exchange-alt', Book::class)
            ->setController(BookGetterSetterCrudController::class);
        yield MenuItem::linkToCrud('2. Manual Controller', 'fas fa-tools', Book::class)
            ->setController(BookManualCrudController::class);
        yield MenuItem::linkToCrud('3. Best Practice', 'fas fa-star', Book::class)
            ->setController(BookBestPracticeCrudController::class);


    }
}
