<?php

namespace App\Repository;

use App\Entity\Weakness;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Weakness|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weakness|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weakness[]    findAll()
 * @method Weakness[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeaknessRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weakness::class);
    }

    // /**
    //  * @return Weakness[] Returns an array of Weakness objects
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
    public function findOneBySomeField($value): ?Weakness
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
