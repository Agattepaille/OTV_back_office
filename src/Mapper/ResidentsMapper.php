<?php

namespace App\Mapper;

use App\Entity\Residents;

class ResidentsMapper
{
    public function mapToEntity(Residents $resident, $data): Residents
    {
        // Set the attributes on the entity
        if (isset($data['civility'])) {
            $resident->setCivility($data['civility']);
        } elseif (isset($data['otherCivility'])) {
            $resident->setCivility($data['otherCivility']);
        }        
        $resident->setLastname($data['lastname'] ?? null);
        $resident->setFirstname($data['firstname'] ?? null);

        return $resident;
    }

    public function mapToUpdatedEntity(Residents $resident, $data): Residents
    {
        // Set the attributes on the entity
        $resident->setCivility($data['civility'] ?? null);

        return $resident;
    }
}