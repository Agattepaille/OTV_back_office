<?php

namespace App\Repository;

use App\Entity\Districts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Districts>
 */
class DistrictsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Districts::class);
    }


  /*   public function findIdByName($name)
    {
        $district = $this->findOneBy(['name' => $name]);

        if (!$district) {
            // Create a new district if none is found
            $district = new Districts();
            $district->setName($name);

            $this->_em->persist($district);
            $this->_em->flush();
        }

        return $district;
    } */

    //    /**
    //     * @return Districts[] Returns an array of Districts objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findOneByName($value): ?Districts
       {
           return $this->createQueryBuilder('d')
               ->andWhere('d.name = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
