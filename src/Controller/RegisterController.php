<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class RegisterController extends AbstractController
{
    private $passwordHasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $manager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->manager = $manager;

    }




    #[Route('/inscription', name: 'register')]
    public function index(Request $request): Response
    {
        $user = new User();



        $form = $this->createForm(RegisterType::class, $user);


        $form->handleRequest($request);

       if($form->isSubmitted()&&$form->isValid()){

      

      $hashedPassword = $this->passwordHasher->hashPassword(
        $user,
        $user->getPassword()
      );
      $user->setPassword($hashedPassword);

//Persiste les données dans le temps 
$this->manager->persist($user);

//ecrit dans la BDD
$this ->manager->flush();

       }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
