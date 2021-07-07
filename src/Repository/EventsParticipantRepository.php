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
    
    public function findByPartication(int $evenement,int $user)
    {
        return $this->createQueryBuilder('e')
            ->where('e.evenement = :evenement')
            ->andWhere('e.user = :user')
            ->setParameters(array('evenement'=> $evenement, 'user' => $user))
            ->getQuery()
            ->getOneOrNullResult()
           // ->getResult()
        ;
    }
    public function findEventUser(int $userId)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.user = :val')
            ->setParameter('val',$userId)
            ->getQuery()
            ->getResult()
        ;
    }
    

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
