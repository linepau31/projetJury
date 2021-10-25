<?php

namespace App\Repository;

use App\Entity\Blogpost;
use App\Entity\Commentary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentary[]    findAll()
 * @method Commentary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentary::class);
    }


    public function findCommentaires($value)
    {
        if ($value instanceof  Blogpost) {
            $object = 'blogpost';
        }
        return $this->createQueryBuilder('c')
            ->andWhere('c.' . $object . ' = :val')
            ->andWhere('c.isPublished = true')
            ->setParameter('val', $value->getId())
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


}
