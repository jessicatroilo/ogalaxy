<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ModifyProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('pseudo', TextType::class, [
            'label' => 'Pseudo',
        ])

        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
        ])

        ->add('lastname', TextType::class, [
            'label' => 'Nom',
        ])

        ->add('email', EmailType::class, [
            'label' => 'Adresse email',
        ])

        ->add('picture', FileType::class, [
            'label' => 'Photo de profil',
            'required' => false,
            'data_class' => null,
            'mapped' => false,
        ])

        ->add('password', PasswordType::class, [
            'label' => 'Modifier le mot de passe',
            'required' => false,
            'hash_property_path' => 'password',
            'mapped' => false,
            'constraints' => [
                new Length([
                    'min' => 8,
                    'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
                new Regex([
                    // this regex check that the password contains at least 8 characters including 1 lower case, 1 upper case, 1 number and 1 special character
                    'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                    'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                ]),
            ],
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
