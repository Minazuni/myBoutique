<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\CarrierCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

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
        return $this->render('admin/Dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MyBoutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::section('Commandes');
        yield MenuItem::linkToCrud('Administrateur', 'fas fa-users', User::class)->setController(AdminCrudController::class);
        yield MenuItem::section('Commandes');
        yield MenuItem::linkToCrud('Catégorie', 'fas fa-folder', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-tags', Product::class)->setController(ProductCrudController::class);
        yield MenuItem::linkToCrud('Transporteur', 'fas fa-truck', Carrier::class)->setController(CarrierCrudController::class);
    }
}
