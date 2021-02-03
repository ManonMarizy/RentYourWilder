<?php

namespace App\Repository;

use App\Entity\WilderHasSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WilderHasSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method WilderHasSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method WilderHasSkill[]    findAll()
 * @method WilderHasSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WilderHasSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WilderHasSkill::class);
    }

    // /**
    //  * @return WilderHasSkill[] Returns an array of WilderHasSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WilderHasSkill
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
