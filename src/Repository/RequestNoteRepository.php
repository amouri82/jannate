<?php

namespace App\Repository;

use App\Entity\RequestNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RequestNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestNote[]    findAll()
 * @method RequestNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestNote::class);
    }

    // /**
    //  * @return RequestNote[] Returns an array of RequestNote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RequestNote
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
