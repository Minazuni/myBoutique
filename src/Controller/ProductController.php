<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SearchFilters;
use App\Form\SearchFiltersType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
	#[Route('/nos-produits', name: 'products')]
	public function index(Request $request, ProductRepository $repo): Response
	{

		$searchFilter = new SearchFilters();
		$form = $this->createForm(SearchFiltersType::class, $searchFilter);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			if (count($searchFilter->getCategories()) > 0) {
				foreach ($searchFilter->getCategories() as $categorie) {


					$tabId[] = $categorie->getId();
				}

				$products = $repo->findByCategory($tabId);
			}
			else{
				$products = $repo->findAll();
			}

			//	$id = $searchFilter->getCategories()->getId();

			//$products= $repo->findByCategory($id);
		} else {
			$products = $repo->findAll();
		}



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






		return $this->render('product/products.html.twig', [
			'products' => $products,
			'form' => $form->createView(),
		]);
	}



	#[Route('/produit/{slug}', name: 'product')]
	public function produit(Product $product): Response
	{



		return $this->render('product/product.html.twig', [

			'product' => $product
		]);
	}
}