<?php

namespace App\Repository;

use App\Entity\EventsParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventsParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventsParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventsParticipant[]    findAll()
 * @method EventsParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventsParticipant::class);
    }

    // /**
    //  * @return EventsParticipant[] Returns an array of EventsParticipant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventsParticipant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
