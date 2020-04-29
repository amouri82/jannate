<?php

namespace App\Repository;

use App\Entity\SalaryPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalaryPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalaryPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalaryPackage[]    findAll()
 * @method SalaryPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryPackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalaryPackage::class);
    }

    // /**
    //  * @return SalaryPackage[] Returns an array of SalaryPackage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalaryPackage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
