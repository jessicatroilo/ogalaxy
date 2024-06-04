<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'label' => 'Titre',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('picture', TextType::class, [
            'label' => 'Image',
            'required' => false,
            'attr' => ['class' => 'form-control'],
        ])
        ->add('text', TextareaType::class, [
            'label' => 'Texte',
            'attr' => ['class' => 'form-control', 'rows' => 5],
        ])
        ->add('createdAt', HiddenType::class, [
            'mapped' => false,
        ])
        ->add('updatedAt', HiddenType::class, [
            'mapped' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
