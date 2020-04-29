<?php

namespace App\Repository;

use App\Entity\ParentAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParentAccount|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentAccount[]    findAll()
 * @method ParentAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentAccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentAccount::class);
    }

    // /**
    //  * @return ParentAccount[] Returns an array of ParentAccount objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParentAccount
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
