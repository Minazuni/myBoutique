<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['required'=>false,'label' => false, 'attr' => ['placeholder' => 'entrez votre Prénom']])
            ->add('lastName', TextType::class, ['required'=>false,'label' => false, 'attr' => ['placeholder' => 'entrez votre Nom de famille']])
            ->add('email', TextType::class ,['required'=>false,])
            //->add('roles')
            ->add('confirmPassword', passwordType::class,['required'=>false,'label' => false, 'attr' => ['placeholder' =>  'confirmez votre mot de passe ']])
            ->add('password', PasswordType::class, ['required'=>false,'label' => false, 'attr' => ['placeholder' => 'entrez votre mot de passe']])
            ->add('submit', SubmitType::class, ['label' => "s'inscrire", 'attr' => ['class' => 'btn-success col-12']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['register'],
        ]);
    }
}
