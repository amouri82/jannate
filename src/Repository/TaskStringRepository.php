<?php

namespace App\Repository;

use App\Entity\TaskString;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskString|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskString|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskString[]    findAll()
 * @method TaskString[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskStringRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskString::class);
    }

    // /**
    //  * @return TaskString[] Returns an array of TaskString objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskString
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
