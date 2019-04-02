<?php

namespace App\Repository;

use App\Entity\WindowsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WindowsType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WindowsType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WindowsType[]    findAll()
 * @method WindowsType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WindowsTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WindowsType::class);
    }

    // /**
    //  * @return WindowsType[] Returns an array of WindowsType objects
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
    public function findOneBySomeField($value): ?WindowsType
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
