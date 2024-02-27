<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-produits', name: 'products')]
    public function index(EntityManagerInterface $entityManager,ProductRepository $repo): Response
    {






        // aller chercher un produit : 
        //  $product = $entityManager->getRepository(Product::class)->find(16);

        // aller chercher tout les produits :
        // $product = $entityManager->getRepository(Product::class)->findAll();

        //    aller cherche le produit dont le sousTitre est :
        //    $product = $entityManager->getRepository(Product::class)->findOneBySubtitle('tempore eos ratione')

        // produits qui ont un soutitre commun :
        // $product = $entityManager->getRepository(Product::class)->findBySubtitle('tempore eos ratione')
       
        // les produits de la categorie 121 en ordre decroissant
        // $product = $entityManager->getRepository(Product::class)->findBy(['category'=>121],['price'=>'desc']);





        return $this->render('product/products.html.twig', ['products'=>$repo->findAll()]);
    }
}
