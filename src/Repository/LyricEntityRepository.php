<?php

namespace App\Repository;

use App\Entity\LyricEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LyricEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method LyricEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method LyricEntity[]    findAll()
 * @method LyricEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyricEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LyricEntity::class);
    }

    // /**
    //  * @return LyricEntity[] Returns an array of LyricEntity objects
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
    public function findOneBySomeField($value): ?LyricEntity
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
