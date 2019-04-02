<?php

namespace App\Repository;

use App\Entity\FlatPreference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FlatPreference|null find($id, $lockMode = null, $lockVersion = null)
 * @method FlatPreference|null findOneBy(array $criteria, array $orderBy = null)
 * @method FlatPreference[]    findAll()
 * @method FlatPreference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlatPreferenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FlatPreference::class);
    }

    // /**
    //  * @return FlatPreference[] Returns an array of FlatPreference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FlatPreference
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
