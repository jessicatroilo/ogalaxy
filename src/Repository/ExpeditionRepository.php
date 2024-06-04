<?php

namespace App\Repository;

use App\Entity\Expedition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expedition>
 *
 * @method Expedition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expedition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expedition[]    findAll()
 * @method Expedition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpeditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expedition::class);
    }
    /**
     * @return Expedition[] Returns an array of Expedition objects by five
     */

    // passing the maxResults parameter to the query
    public function findByFive(int $maxResults = 5): array {
        $entityManager = $this->getEntityManager();

        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Expedition e
            WHERE e.price < 80000
            '
        )->setMaxResults($maxResults);

        // returns an array of Expedition objects
        return $query->getResult();
    }

    /**
     * @return Expedition[] Returns an array of Expedition objects by departure
     */
    public function findByDeparture(int $maxResults = 5): array {

        $entityManager = $this->getEntityManager();

        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Expedition e
            ORDER BY e.departure asc 
            '
        )->setMaxResults($maxResults);

        // returns an array of Expedition objects
        return $query->getResult();
    }

    /**
     * @return Expedition[] Returns an array of Expedition objects by rating
     */ 
    public function findByBestRating(int $maxResults = 5): array {
        
        $entityManager = $this->getEntityManager();

        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Review r, App\Entity\Expedition e
            WHERE r.expedition = e.id
            AND r.rating >= 5
            '
        )->setMaxResults($maxResults);

        // returns an array of Expedition objects
        return $query->getResult();
    }

    /**
     * @return Expedition[] Returns an array of Expedition objects by title
     */
    public function findByTitle($title)
    {
        return $this->createQueryBuilder('e')
            ->where('e.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->getResult();
            
    }

    /**
     * @return Expedition[] Returns an array of Expedition objects by description
     */
    public function findByDescription($description)
    {
        return $this->createQueryBuilder('e')
            ->where('e.description LIKE :description')
            ->setParameter('description', '%'.$description.'%')
            ->getQuery()
            ->getResult();
            
    }

}   




    