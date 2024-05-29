<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    private $articles = [];

    public function load(ObjectManager $manager): void
    {
        $this->initArticles();

        foreach ($this->articles as $articleData) {
            $article = new Article();
            $article->setTitle($articleData['title']);
            $article->setPicture($articleData['picture']);
            $article->setText($articleData['text']);
            $article->setCreatedAt(new \DateTimeImmutable($articleData['created_at']->format('Y-m-d H:i:s')));

            $manager->persist($article);
        }

        $manager->flush();
    }

    private function initArticles(): void
    {
        $this->articles = [
            [
                'title' =>  'Les 10 lieux incontournables à visiter sur Tatooine',
                'picture' => 'https://th.bing.com/th/id/OIG4.CIQNFEwwNFLkn5qEvOAG?w=1024&h=1024&rs=1&pid=ImgDetMain',
                'text' => 'Tatooine est une planète désertique connue pour ses deux soleils et ses paysages arides. Dans cet article, nous allons explorer les 10 lieux incontournables à visiter sur Tatooine, de la vallée des Jedi à la mer de dunes en passant par Mos Eisley et Jabba le Hutt\'s Palace.',
                'created_at' => new \DateTimeImmutable('2024-02-13'),
            ],
            [
                'title' =>  'Découvrez les merveilles de la planète Naboo',
                'picture' => 'https://th.bing.com/th/id/OIG4.6akfEqYuUM0vObG_v11R?w=1024&h=1024&rs=1&pid=ImgDetMain',
                'text' => 'Naboo est une planète verdoyante et paisible, connue pour ses paysages magnifiques et sa culture riche. Dans cet article, nous allons découvrir les merveilles de la planète Naboo, de la ville de Theed aux chutes d\'eau de Gungan City en passant par les lacs et les forêts luxuriantes.',
                'created_at' => new \DateTimeImmutable('2024-01-22'),
            ],
            [
                'title' =>  'Les secrets de la planète Coruscant',
                'picture' => 'https://th.bing.com/th/id/OIG3.YydTr5wjHkGpEe3asQVs?w=270&h=270&c=6&r=0&o=5&pid=ImgGn',
                'text' => 'Coruscant est une planète-ville, le centre politique et économique de la galaxie. Dans cet article, nous allons explorer les secrets de la planète Coruscant, de la tour Jedi aux niveaux inférieurs en passant par les quartiers chics et les zones industrielles.',
                'created_at' => new \DateTimeImmutable('2024-01-14'),
            ],
            [
                'title' =>  'Les plus belles plages de Scarif',
                'picture' => 'https://th.bing.com/th/id/OIG4.Rds2wxA2GrGpz6gcadgg?w=1024&h=1024&rs=1&pid=ImgDetMain',
                'text' => 'Scarif est une planète tropicale connue pour ses plages de sable blanc et ses eaux cristallines. Dans cet article, nous allons découvrir les plus belles plages de Scarif, de la plage de Jedha à la plage de Scarif City en passant par les criques cachées et les lagons.',
                'created_at' => new \DateTimeImmutable('2024-03-22'),
            ],
            [
                'title' =>  'La planète Mustafar : un voyage dans les entrailles de la galaxie',
                'picture' => 'https://th.bing.com/th/id/OIG4.kndNhaar2zQQAOiIdjKR?w=1024&h=1024&rs=1&pid=ImgDetMain',
                'text' => 'Mustafar est une planète volcanique, connue pour ses rivières de lave et ses paysages infernaux. Dans cet article, nous allons explorer les entrailles de la planète Mustafar, de la forteresse de Dark Vador aux mines de lave en passant par les champs de lave et les grottes.',
                'created_at' => new \DateTimeImmutable('2024-04-12'),
            ],
        ];
    }
}
