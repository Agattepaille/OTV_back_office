<?php

namespace App\Mapper;

use App\Entity\Address;

class AddressMapper
{
    public function mapToEntity(Address $address, $data): Address
    {
        // Set the attributes on the entity
        $address->setStreet($data['street'] ?? null);
        $address->setStreetNumber($data['streetNumber'] ?? null);
        $address->setAdditionnalStreetNumber($data['additionalStreetNumber'] ?? null);
        $address->setAdditionalAddressInfo($data['additionalAddressInfo'] ?? null);
        
        return $address;
    }

  /*   public function mapToUpdatedEntity(Residents $resident, $data): Residents
    {
        // Set the attributes on the entity
        $resident->setCivility($data['civility'] ?? null);

        return $resident;
    } */
}