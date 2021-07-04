<?php

namespace App\Repository;

use App\Entity\Shifts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shifts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shifts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shifts[]    findAll()
 * @method Shifts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShiftsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shifts::class);
    }

    // /**
    //  * @return Shifts[] Returns an array of Shifts objects
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
    public function findOneBySomeField($value): ?Shifts
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
