<?php

namespace App\Repository;

use App\Entity\HeadCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HeadCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeadCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeadCategory[]    findAll()
 * @method HeadCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeadCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeadCategory::class);
    }

    // /**
    //  * @return HeadCategory[] Returns an array of HeadCategory objects
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
    public function findOneBySomeField($value): ?HeadCategory
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
