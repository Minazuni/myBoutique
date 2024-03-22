<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart 
{

    private $requestStack;

    public function __construct( RequestStack $requestStack,)
     {
      
        $this->requestStack = $requestStack;
    }

//ajout d'un id d'un produit
public function add($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);


        //on test si le produit correspondant a l'id est vide

        if (!empty($cart[$id])) {

            $cart[$id]++;
        } else $cart[$id] = 1; //ajout d'une seule quantité




        $this->requestStack->getSession()->set('cart', $cart);
    }



    //recupération du panier
public function get(){

    return   $this-> requestStack->getSession()->get('cart',[]);
}


public function remove(){

    return   $this-> requestStack->getSession()->remove('cart');


}

public function rm($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);


        if (!empty($cart[$id])) {
            $cart[$id]--;
        }
        else return $this->requestStack->getSession()->remove('cart');

        $this->requestStack->getSession()->set('cart', $cart);
    }
}