<?php

namespace App\Repository;

use App\Entity\LyricsEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LyricsEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method LyricsEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method LyricsEntity[]    findAll()
 * @method LyricsEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LyricsEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LyricsEntity::class);
    }

    // /**
    //  * @return LyricsEntity[] Returns an array of LyricsEntity objects
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
    public function findOneBySomeField($value): ?LyricsEntity
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
