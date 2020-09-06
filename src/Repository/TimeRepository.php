<?php

namespace App\Repository;

use App\Entity\Time;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Time|null find($id, $lockMode = null, $lockVersion = null)
 * @method Time|null findOneBy(array $criteria, array $orderBy = null)
 * @method Time[]    findAll()
 * @method Time[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Time::class);
    }

    // /**
    //  * @return Time[] Returns an array of Time objects
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
    public function findOneBySomeField($value): ?Time
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getTeacherTimes(Employee $teacher)
    {
        return $this->createQueryBuilder('t')            
            ->where('t.id >= :startTime1 AND t.id <= :endTime1')
            ->orWhere('t.id >= :startTime2 AND t.id <= :endTime2')
            ->orWhere('t.id >= :startTime3 AND t.id <= :endTime3')
            ->setParameter('startTime1', $teacher->getStartTime1())
            ->setParameter('endTime1', $teacher->getEndTime1())
            ->setParameter('startTime2', $teacher->getStartTime2())
            ->setParameter('endTime2', $teacher->getEndTime2())
            ->setParameter('startTime3', $teacher->getStartTime3())
            ->setParameter('endTime3', $teacher->getEndTime3())
            ->getQuery()
            ->getResult()
        ;
    }    
}
