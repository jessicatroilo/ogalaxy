<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function findByWaitingStatus($user = null): array
    {
        $entityManager = $this->getEntityManager();

        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Booking b
            WHERE b.booking_status = 1
            AND b.user = :user_id
            '
        )
        ->setParameter('user_id', $user)
        ->setMaxResults(5);

        // returns an array of Expedition objects
        return $query->getResult();
    }

    public function findByValidateStatus($user = null): array
    {
        $entityManager = $this->getEntityManager();
    
        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Booking b
            WHERE b.booking_status = 2
            AND b.user = :user_id
            '
        )
        ->setParameter('user_id', $user)
        ->setMaxResults(5);
    
         // returns an array of Expedition objects
        return $query->getResult();
    }

    public function findByCanceledStatus($user = null): array
    {
        $entityManager = $this->getEntityManager();

        // creation of the query to find the desired data
        $query = $entityManager->createQuery(
            'SELECT b
            FROM App\Entity\Booking b
            WHERE b.booking_status = 3
            AND b.user = :user_id
            '
        )
        ->setParameter('user_id', $user)
        ->setMaxResults(5);

        // returns an array of Expedition objects
        return $query->getResult();
    }
}
