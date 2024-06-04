<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Expedition;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use App\Repository\ExpeditionRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserBookingType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $userChoices = [];
        if ($user) {
            $userChoices = [$user];
        }

        $builder
            ->add('user', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        // Function for formatting user informations
                        return sprintf('%s %s - %s', $user->getFirstname(), $user->getLastname(), $user->getEmail());
                    },
                    'label' => 'Voyageur',
                    'choices' => $userChoices,
                ])

            ->add('expedition', EntityType::class, [
                'class' => Expedition::class,
                'query_builder' => function (ExpeditionRepository $er) use ($options) {
                    $expedition = $options['expedition'];
                    return $er->createQueryBuilder('e')
                        ->where('e.id = :expeditionId')
                        ->setParameter('expeditionId', $expedition->getId());
                },
                'label' => 'Destination',

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
            'expedition' => null, // Get expedition who come from of the controller
        ]);
    }
}
