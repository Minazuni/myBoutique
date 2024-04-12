<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Services\Cart;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Stripe\Checkout\Session;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/compte/commande', name: 'order')]
    public function index(Request $request, Cart $cart, ProductRepository $repo, EntityManagerInterface $manager): Response
    {




        if (!$this->getUser()->getAddresses()->getValues()) {

            return $this->redirectToRoute('account_add_address');
        }

        $cart = $cart->get();
        $cartComplete = [];
        foreach ($cart as $id => $quantity) {
            $cartComplete[] = [
                'product' => $repo->findOneById($id),
                'quantity' => $quantity,
            ];
        }


        $form = $this->createForm(OrderType::class, null, ['user' => $this->getUser()]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
$reference= uniqid();

            // dd($form->getData());
            //dd($form->get('addresses')->getData());
            //dd($form->get('trasporteurs')->getData());
            $order = new Order();
            $order->setUser($this->getUser())
                ->setCarrier($form->get('transporteur')->getData())
                ->setDelivery($form->get('addresses')->getData())
                ->setCreatedAt(new \DateTime())
                ->setStatut(0)
                ->setReference(uniqid());


            $manager->persist($order);

            foreach ($cartComplete as $product) {

                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order)
                    ->setProduct($product['product'])
                    ->setQuantity($product['quantity'])
                    ->setPrice($product['product']->getPrice());

                $manager->persist($orderDetails); 
                
                
            $stripe_products[] = [
                'price_data'=>[
                  'currency'=>'eur',
                  'product_data'=>[
                           'name'=> $product['product']->getName(),
                           'images'=>[
                            
                            
                            $_SERVER['HTTP_ORIGIN'].'/uploads/'.$product['product']->getPicture()]
              
          ],
          'unit_amount'=>$product['product']->getPrice(),
      ],
      'quantity'=>$product['quantity']
    ];
            }
            
            $stripe_products[] =  [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [
                            $_SERVER['HTTP_ORIGIN'].'/uploads/'.$product['product']->getPicture()
                        ]
                    ],
                    'unit_amount' => $product['product']->getPrice(),
                ],
                'quantity' => $product['quantity']
            ];





            $YOUR_DOMAIN = $_SERVER['HTTP_ORIGIN'];

            $stripeSecretKey =$this->getParameter('STRIPE_KEY');

            Stripe::setApiKey($stripeSecretKey);



            $checkout_session = Session::create([
                'line_items'=> $stripe_products,
                 'mode' => 'payment',
                 'success_url' => $YOUR_DOMAIN . '/compte/commande/merci/{CHECKOUT_SESSION_ID}-'.$order->getReference(),
                 'cancel_url' => $YOUR_DOMAIN . '/compte/commande/erreur/{CHECKOUT_SESSION_ID}',
             ]);
//dd($form->get('transporteur')->getData());
              //dd($checkout_session->url);
            //$manager->flush();

            return $this->render('order/recap.html.twig', [

                'cart' => $cartComplete,
                'order' => $order,
                'url_stripe'=>$checkout_session->url
            ]);
        }


        return $this->render('order/order.html.twig', [
            'form' => $form->createView(),
            'cart' => $cartComplete

        ]);
    }
}
