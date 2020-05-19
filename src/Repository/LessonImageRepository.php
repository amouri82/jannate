<?php

namespace App\Repository;

use App\Entity\LessonImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LessonImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonImage[]    findAll()
 * @method LessonImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LessonImage::class);
    }

    // /**
    //  * @return LessonImage[] Returns an array of LessonImage objects
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
    public function findOneBySomeField($value): ?LessonImage
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
