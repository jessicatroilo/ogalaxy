<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Review;
use App\Entity\Expedition;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user= $this->security->getUser();
        $userChoices = [];
        if ($user) {
            $userChoices = [$user];
            }


        $builder
            ->add('user', EntityType::class,  [
                'class' => User::class,
                'choice_label' => 'pseudo',
                "label" => " Voyageur",
                'choices' => $userChoices,
            ])

            ->add('comment', TextareaType::class, [
                "label" => "Votre commentaire",
                "help" => "Votre commentaire doit être constructif et respectueux. Merci de ne pas utiliser de langage inapproprié.",
            ])
        
            ->add('rating', ChoiceType::class, [
                "label" => "Note",
                "choices" => [
                    "Excellent" => 5,
                    "Très bien" => 4,
                    "Bien" => 3,
                    "Moyen" => 2,
                    "Mauvaise expérience" => 1
                ], 
                "multiple" => false,
                "expanded" => true,
                ])

            ->add('picture', FileType::class, [
                'label' => 'Photos  de l\'expédition',
                    'required' => false,
                    'data_class' => null,
                    'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}