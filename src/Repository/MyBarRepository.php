<?php

namespace App\Repository;

use App\Entity\MyBar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyBar|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyBar|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyBar[]    findAll()
 * @method MyBar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyBarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyBar::class);
    }

    // /**
    //  * @return MyBar[] Returns an array of MyBar objects
    //  */

   /* public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    } */


    /*
    public function findOneBySomeField($value): ?MyBar
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
