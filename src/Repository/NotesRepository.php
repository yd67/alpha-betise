<?php

namespace App\Repository;

use App\Entity\Notes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notes[]    findAll()
 * @method Notes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    // /**
    //  * @return Notes[] Returns an array of Notes objects
    //  */
    
    public function note($id):array
    {
        return $this->createQueryBuilder('n')
            ->select('avg(n.note)')
            ->andWhere('n.livre = :val')
            ->setParameter('val', $id)
            // ->orderBy('n.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // public function noteMoyenne(int $id):array
    // {
    //     $conn = $this->getEntityManager()->getConnection();

    //     $sql = '
    //     SELECT livre_id, AVG(note) FROM notes
    //     WHERE livre_id = :id 
    //     ';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(['id' => $id]);

    //     $result = $stmt->fetchAllAssociative();
        
    //     return $result ;

    // }
    

    /*
    public function findOneBySomeField($value): ?Notes
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
