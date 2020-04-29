<?php

namespace App\Repository;

use App\Entity\Head;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Head|null find($id, $lockMode = null, $lockVersion = null)
 * @method Head|null findOneBy(array $criteria, array $orderBy = null)
 * @method Head[]    findAll()
 * @method Head[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Head::class);
    }

    // /**
    //  * @return Head[] Returns an array of Head objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Head
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
