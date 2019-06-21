<?php

namespace App\Repository;

use App\Entity\Flat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Flat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flat[]    findAll()
 * @method Flat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Flat::class);
    }

    /**
     * @param array $criteria
     * @return \Doctrine\ORM\Query
     */
    public function search($criteria=[])
    {
        $qb = $this->createQueryBuilder('flat')
            ->select('flat, city')
            ->innerJoin('flat.city','city');


        if(isset($criteria['city']) && $criteria['city'])
        {
            $qb->andWhere('flat.city = :city')
                ->setParameter('city', $criteria['city']);
        }
        elseif(isset($criteria['region']) && $criteria['region'])
        {
            $qb->andWhere('city.region = :region')
                ->setParameter('region', $criteria['region']);
        }

        if(isset($criteria['priceFrom']))
        {
            $qb->andWhere('flat.price >= :priceFrom')
                ->setParameter('priceFrom', $criteria['priceFrom']);
        }

        if(isset($criteria['priceTo']))
        {
            $qb->andWhere('flat.price <= :priceTo')
                ->setParameter('priceTo', $criteria['priceTo']);
        }

        if(isset($criteria['flatType']))
        {
            $qb->andWhere('flat.flatType IN (:flatType)')
                ->setParameter('flatType', $criteria['flatType']);
        }

        if(isset($criteria['buildingType']))
        {
            $qb->andWhere('flat.buildingType IN (:buildingType)')
                ->setParameter('buildingType', $criteria['buildingType']);
        }

        if(isset($criteria['heatingType']))
        {
            $qb->andWhere('flat.heatingType IN (:heatingType)')
                ->setParameter('heatingType', $criteria['heatingType']);
        }

        if(isset($criteria['kitchenType']))
        {
            $qb->andWhere('flat.kitchenType IN (:kitchenType)')
                ->setParameter('kitchenType', $criteria['kitchenType']);
        }

        if(isset($criteria['windowsType']))
        {
            $qb->andWhere('flat.windowsType IN (:windowsType)')
                ->setParameter('windowsType', $criteria['windowsType']);
        }
        
        if(isset($criteria['dist']))
            $qb->andWhere('ACOS(SIN(PI()*city.lat/180.0)*SIN(PI()*'.$criteria['lat'].'/180.0)+COS(PI()*city.lat/180.0)*COS(PI()*'.$criteria['lat'].'/180.0)*COS(PI()*'.$criteria['lon'].'/180.0-PI()*city.lon/180.0))*6371 < '.$criteria['dist']);

        $qb->orderBy('flat.createdAt','DESC');

        return $qb->getQuery();
    }

    // /**
    //  * @return Flat[] Returns an array of Flat objects
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
    public function findOneBySomeField($value): ?Flat
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
