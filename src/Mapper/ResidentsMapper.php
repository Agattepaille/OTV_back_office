<?php

namespace App\Mapper;

use App\Entity\Residents;

class ResidentsMapper
{
    public function mapToEntity(Residents $resident, $data): Residents
    {


        // Set the attributes on the entity
        $resident->setCivility($data['civility'] ?? null);
        $resident->setLastname($data['lastname'] ?? null);
        $resident->setFirstname($data['firstname'] ?? null);
        $resident->setMobilePhone($data['mobilePhone'] ?? null);
        $resident->setLandlinePhone($data['landlinePhone'] ?? null);
        $resident->setEmail($data['email'] ?? null);
        $resident->setStreet($data['street'] ?? null);
        $resident->setStreetNumber($data['streetNumber'] ?? null);
        $resident->setAdditionalStreetNumber($data['additionalStreetNumber'] ?? null);
        $resident->setAdditionalAddressInfo($data['additionalAddressInfo'] ?? null);



        // $resident->setAuthorization($data['authorization']);
        // ... set other properties as needed

        return $resident;
    }
}
