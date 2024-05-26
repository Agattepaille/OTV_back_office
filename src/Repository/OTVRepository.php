<?php

namespace App\Repository;

use App\Entity\OTV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OTV>
 */
class OTVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OTV::class);
    }

    // renomme les clés du tableau JSON pour les afficher dans le tableau
    public function renameJsonKeys(array $data, array $keyMapping): array
    {
        $renamedData = [];
        foreach ($data as $key => $value) {
            $newKey = $keyMapping[$key] ?? $key;
            if (is_array($value)) {
                $renamedData[$newKey] = $this->renameJsonKeys($value, $keyMapping);
            } else {
                $renamedData[$newKey] = $value;
            }
        }
        return $renamedData;
    }

    public function getRenamedData(OTV $otv): array
    {
        $data = $otv->getData();

        // Mapping des clés à renommer
        $keyMapping = [
            'authorizedPersons' => 'Personnes autorisées',
            'car' => 'Voiture',
            'emergencyContact1' => 'Personne1',
            'emergencyContact2' => 'Personne2',
            'emergencyContact3' => 'Personne3',
            'civility' => 'Civilité',
            'lastname' => 'Nom',
            'firstname' => 'Prénom',
            'mobilePhone' => 'Téléphone portable',
            'landlinePhone' => 'Téléphone fixe',
            'email' => 'Courriel',
            'authorization' => 'Autorisation',
            'houseType' => 'Type de logement',
            'hasAlarm' => 'Alarme',
            'hasAlarmExt' => 'Alarme extérieure',
            'hasAnimal' => 'Animal',
            'hasCamera' => 'Caméra',
            'blindsSchedule' => 'Horaire des volets',
            'lightsSchedule' => 'Horaire des éclairages',
            'additionalInfo' => 'Informations supplémentaires',
            'otvInfo' => 'Informations supplémentaires',

        ];

        return $this->renameJsonKeys($data, $keyMapping);
    }

       /**
        * @return OTV[] Returns an array of OTV objects
        */
    public function findByStatus(bool $pending): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.pending = :val')
            ->setParameter('val', $pending)
            // ->orderBy('o.residents.districts_id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByStatusAndDistrict(bool $pending, string $districtName): array
    {
        return $this->createQueryBuilder('o')
            ->join('o.residents', 'r')
            ->join('r.districts', 'd')
            ->andWhere('o.pending = :pending')
            ->andWhere('d.name = :districtName')
            ->setParameter('pending', $pending)
            ->setParameter('districtName', $districtName)
            ->orderBy('o.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return OTV[] Returns an array of OTV objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

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
