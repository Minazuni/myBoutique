<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Services\Cart;
use App\Form\OrderType;
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
            }


            $manager->flush();

            return $this->render('order/recap.html.twig', [

                'cart' => $cartComplete,
                // 'order' => $order,
            ]);
        }


        return $this->render('order/order.html.twig', [
            'form' => $form->createView(),
            'cart' => $cartComplete

        ]);
    }
}
