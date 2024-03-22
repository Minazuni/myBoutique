<?php

namespace App\Controller;

use App\Services\Cart;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart,ProductRepository $repo): Response
    {
//$cart -> add(2);
//$cart -> add(1);

  $cart = $cart->get();
$cartComplete = [];
foreach ($cart as $id => $quantity) {
    
   $cartComplete[]=[
    'product'=> $repo->findOneById($id),
    'quantity'=>$quantity

   
   
   ];

}





       
        return $this->render('cart/cart.html.twig', [
            'cart' => $cartComplete,
        ]);
    }
    
    
    
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart,$id)
    {

        $cart->add($id);
        return $this->redirectToRoute("cart");

    }

    
    
    
    #[Route('/cart/remove', name: 'remove_cart')]
    public function remove(Cart $cart){

        $cart ->remove();
        return $this->redirectToRoute("cart");
    }

    #[Route('/cart/rm/{id}', name: 'rm_cart')]
    public function rm(Cart $cart, $id)
    {

        $cart->rm($id);

        return $this->redirectToRoute('cart');
    }
}
