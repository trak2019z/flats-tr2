<?php

namespace App\Repository;

use App\Entity\KitchenType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method KitchenType|null find($id, $lockMode = null, $lockVersion = null)
 * @method KitchenType|null findOneBy(array $criteria, array $orderBy = null)
 * @method KitchenType[]    findAll()
 * @method KitchenType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KitchenTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, KitchenType::class);
    }

    // /**
    //  * @return KitchenType[] Returns an array of KitchenType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KitchenType
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
