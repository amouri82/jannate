<?php

namespace App\Repository;

use App\Entity\Mins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mins|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mins|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mins[]    findAll()
 * @method Mins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mins::class);
    }

    // /**
    //  * @return Mins[] Returns an array of Mins objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mins
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
