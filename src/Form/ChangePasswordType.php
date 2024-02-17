<?php

namespace App\Form;
use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordType extends AbstractType
{

 
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, ['label' => 'Mon email', 'disabled' => true])
        //->add('roles')
        //->add('password')
        ->add('firstName', TextType::class, ['label' => 'Mon prénom', 'disabled' => true])
        ->add('lastName', TextType::class, ['label' => 'Mon nom', 'disabled' => true])
        ->add('oldPassword',PasswordType::class,['required'=>false,'label' => false, 'attr' => ['placeholder' => 'entrez votre ancien mot de passe']])
        ->add('newPassword',PasswordType::class,['required'=>false,'label' => false, 'attr' => ['placeholder' => 'entrez votre nouveau mot de passe']])
        ->add('confirmNewPassword',PasswordType::class,['required'=>false,'label' => false, 'attr' => ['placeholder' => 'confirmez votre nouveau mot de passe']])
        ->add('submit', SubmitType::class, ['label' => "modifiez le mot de passe", 'attr' => ['class' => 'btn-success col-12']]);;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
