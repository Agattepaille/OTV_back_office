<?php

namespace App\Repository;

use App\Entity\OTV;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<OTV>
 */
class OTVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OTV::class);
    }

    /**
     * @return OTV[] Returns an array of OTV objects
     */
    public function findByStatus(bool $ongoing): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.pending = :val')
            ->setParameter('val', $ongoing)
            // ->orderBy('o.residents.districts_id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByStatusAndDistrict(bool $ongoing, string $districtName): array
    {
        return $this->createQueryBuilder('o')
            ->join('o.residents', 'r')
            ->join('r.districts', 'd')
            ->andWhere('o.pending = :pending')
            ->andWhere('d.name = :districtName')
            ->setParameter('pending', $ongoing)
            ->setParameter('districtName', $districtName)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return OTV[] Returns an array of OTV objects
     */
    public function findByResidentId($residentId): array
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.residents', 'r')
            ->andWhere('r.id = :id')
            ->setParameter('id', $residentId)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?OTV
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
