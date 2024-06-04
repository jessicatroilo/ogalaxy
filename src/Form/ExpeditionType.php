<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Expedition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ExpeditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('destination', TextType::class, [
                'label' => 'Nom de la destination',
            ])
            ->add('departure', DateType::class, [
                'label' => 'Date de départ',
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée du séjour'
            ])
            ->add('passenger', IntegerType::class, [
                'label' => 'Nombre de voyageurs maximum',
            ])
            ->add('description', TextType::class, [
                'label' => 'Résumé de l\'expédition'
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Image de la destination',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix de la destination',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expedition::class,
        ]);
    }
}
