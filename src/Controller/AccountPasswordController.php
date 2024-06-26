<?php

namespace App\Controller;


use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AccountPasswordController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{

    private $passwordHasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $manager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->manager = $manager;
    }
    #[Route('/compte/modifier-mot-de-passe', name: 'account_password')]
    public function index(Request $request): Response
    {
        // recupere l'utilisateur connecté 
        $user = $this->getUser();
        dump($user);
        $form = $this->createForm(ChangePasswordType::class, $user);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->passwordHasher->isPasswordValid($user, $user->getOldPassword())) {

                $this->addFlash(
                    'danger',
                    'l ancien mot de passe est incorect'
                );
            } else {
                $hashedPassword = $this->passwordHasher->hashPassword(
                    $user,
                    $user->getNewPassword()
                );
                $user->setPassword($hashedPassword);
                //Persiste les données dans le temps 
                $this->manager->persist($user);

                //ecrit dans la BDD
                $this->manager->flush();

                $this->addFlash(
                    'success',
                    'Le mot de passe a bien été modifié'
                );

                return $this->redirectToRoute('account');
            }
        }

        return $this->render('account/accountPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
