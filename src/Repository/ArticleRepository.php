<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllOrderedByDate(): array
    {
        $entityManager = $this->getEntityManager();
    
        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Article a
            ORDER BY a.createdAt DESC'
        );
    
        // returns an array of Article objects
        return $query->getResult();
    }

    public function findByTitle($title)
    {
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->getResult();
            
    }

    public function findByText($text)
    {
        return $this->createQueryBuilder('a')
            ->where('a.text LIKE :text')
            ->setParameter('text', '%'.$text.'%')
            ->getQuery()
            ->getResult();
            
    }
}
