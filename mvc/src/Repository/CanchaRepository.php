<?php

namespace App\Repository;

use App\Entity\Cancha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cancha>
 *
 * @method Cancha|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cancha|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cancha[]    findAll()
 * @method Cancha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CanchaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cancha::class);
    }

//    /**
//     * @return Cancha[] Returns an array of Cancha objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Cancha
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
