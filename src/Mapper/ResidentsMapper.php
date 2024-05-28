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
        }        $resident->setLastname($data['lastname'] ?? null);
        $resident->setFirstname($data['firstname'] ?? null);
        $resident->setMobilePhone($data['mobilePhone'] ?? null);
        $resident->setLandlinePhone($data['landlinePhone'] ?? null);
        $resident->setEmail($data['email'] ?? null);
        $resident->setStreet($data['street'] ?? null);
        $resident->setStreetNumber($data['streetNumber'] ?? null);
        $resident->setAdditionalStreetNumber($data['additionalStreetNumber'] ?? null);
        $resident->setAdditionalAddressInfo($data['additionalAddressInfo'] ?? null);

        return $resident;
    }

    public function mapToUpdatedEntity(Residents $resident, $data): Residents
    {


        // Set the attributes on the entity
        $resident->setCivility($data['civility'] ?? null);
        // $resident->setLastname($data['lastname'] ?? null);
        // $resident->setFirstname($data['firstname'] ?? null);
        $resident->setMobilePhone($data['mobilePhone'] ?? null);
        $resident->setLandlinePhone($data['landlinePhone'] ?? null);
        $resident->setEmail($data['email'] ?? null);
        $resident->setStreet($data['street'] ?? null);
        $resident->setStreetNumber($data['streetNumber'] ?? null);
        $resident->setAdditionalStreetNumber($data['additionalStreetNumber'] ?? null);
        $resident->setAdditionalAddressInfo($data['additionalAddressInfo'] ?? null);

        return $resident;
    }
}
