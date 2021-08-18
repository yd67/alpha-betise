<?php

namespace App\Repository;

use DateTime;
use App\Entity\Evenements;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Evenements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenements[]    findAll()
 * @method Evenements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenements::class);
    }

    // /**
    //  * @return Evenements[] Returns an array of Evenements objects
    //  */
    
    public function findNextEvents(DateTime $dateActuel,int $maxResult)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.start > :val')
            ->setParameter('val', $dateActuel)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults($maxResult)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findOrderAll(string $order)
    {
        return $this->createQueryBuilder('e')
            -> orderBy('e.id', $order)
            ->getQuery()
            ->getResult()
        ;
    }
/*
     $query = $entityManager->createQuery("
        SELECT e FROM App\Entity\Evenements e WHERE e.end > :dateA 
        ")
        ->setParameter('dateA', $dateActuel)
        ->setMaxResults(2)
        ;
        $evenementsAvenir = $query->getResult() ;
    */

    /*
    public function findOneBySomeField($value): ?Evenements
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
