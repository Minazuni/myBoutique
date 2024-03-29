<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Nommez votre adresse']])
            ->add('firstName', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre prénom']])
            ->add('lastName', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre nom']])
            ->add('company', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre société']])
            ->add('address', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre adresse']])
            ->add('postal', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre code postal']])
            ->add('city', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre ville']])
            ->add('country', CountryType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Choissisez votre pays']])
            ->add('phone', TextType::class, ['label' => false, 'required' => false, 'attr' => ['placeholder' => 'Entrez votre telephone']])
            ->add('submit', SubmitType::class, ['label' => "Ajoutez l'adresse", 'attr' => ['class' => 'btn-success col-12']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
