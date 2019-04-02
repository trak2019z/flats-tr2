<?php

namespace App\Repository;

use App\Entity\BathroomType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BathroomType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BathroomType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BathroomType[]    findAll()
 * @method BathroomType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BathroomTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BathroomType::class);
    }

    // /**
    //  * @return BathroomType[] Returns an array of BathroomType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BathroomType
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
