<?php

namespace App\Repository;

use App\Entity\Productsdsdreset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productsdsdreset>
 *
 * @method Productsdsdreset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productsdsdreset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productsdsdreset[]    findAll()
 * @method Productsdsdreset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsdsdresetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productsdsdreset::class);
    }

//    /**
//     * @return Productsdsdreset[] Returns an array of Productsdsdreset objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Productsdsdreset
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
