<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $carrier = new Carrier;

        $builder
            ->add(
                'addresses',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Address::class,
                    'label' => 'Choisissez une adresse de livraison : ',
                    'choices' => $options['user']->getAddresses(),
                    'multiple' => false,
                    'expanded' => true,
                    // 'choice_attr' => $user->getAddresses(),
                ]
            )
            ->add(
                'transporteur',
                EntityType::class,
                [
                    'required' => true,
                    'class' => Carrier::class,
                    'label' => 'Choisissez un Transporteur : ',
                    'choices' => $carrier->getName(),
                    'multiple' => false,
                    'expanded' => true,
                    // 'choice_attr' => $user->getAddresses(),
                ]
            )
            ->add('submit', SubmitType::class, ['label' => "Validez la commande", 'attr' => ['class' => 'btn-success col-12']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => null
        ]);
    }
}
