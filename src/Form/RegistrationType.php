<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                "required" => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Email"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => ['placeholder' => "Mot de passe"]],
                'second_options' =>['label' => false, 'attr' => ['placeholder' => "Confirmer mot de passe"]],
            ])
            ->add('firstname', TextType::class, [
                "required" => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Prénom"
                ]
            ])
            ->add('lastname', TextType::class, [
                "required" => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])
            ->add('phone', TextType::class, [
                "required" => true,
                'label' => false,
                'attr' => [
                    'placeholder' => "Téléphone"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
