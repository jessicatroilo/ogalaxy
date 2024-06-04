<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Expedition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('booking_status', ChoiceType::class, [
                'choices' => [
                    'En attente' => 1,
                    'Validée' => 2,
                    'Annulée' => 3,
                    'Reportée' => 4
                ],
                'label' => 'Statut de la réservation',
                'placeholder' => 'Choisissez un statut'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function ($user) {
                    // Function for formatting user informations
                    return sprintf('%s %s - %s', $user->getFirstname(), $user->getLastname(), $user->getEmail());
                },
                'label' => 'Utilisateur'
            ])
            ->add('expedition', EntityType::class, [
                'class' => Expedition::class,
                'choice_label' => 'title',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
