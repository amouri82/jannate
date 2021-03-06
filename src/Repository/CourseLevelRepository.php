<?php

namespace App\Repository;

use App\Entity\CourseLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseLevel[]    findAll()
 * @method CourseLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseLevel::class);
    }

    // /**
    //  * @return CourseLevel[] Returns an array of CourseLevel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseLevel
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
