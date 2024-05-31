<?php

namespace App\Mapper;

use App\Entity\OTV;
use DateTimeImmutable;
use Exception;


class OTVRequestMapper
{
    public function mapToEntity(OTV $otv, $data): OTV
    {
        $startDate = $this->validateAndConvertDate($data['start_Date']);
        $endDate = $this->validateAndConvertDate($data['end_Date']);

        if ($startDate && $endDate) {
            $otv->setStartDate($startDate);
            $otv->setEndDate($endDate);
        } else {
            throw new Exception("Invalid date format provided.");
        }

        $otv->setMobilePhone($data['mobilePhone'] ?? null);
        $otv->setLandlinePhone($data['landlinePhone'] ?? null);
        $otv->setEmail($data['email'] ?? null);

        $jsonData = [
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'authorizedPersons' => $data['authorizedPersons'] ?? null,
            'car' => $data['car'] ?? null,
            'emergencyContact1' => $this->mapEmergencyContact($data, 1),
            'emergencyContact2' => $this->mapEmergencyContact($data, 2),
            'emergencyContact3' => $this->mapEmergencyContact($data, 3),
            'otvInfo' => [
                'authorization' => $data['authorization'] ?? null,
                'houseType' => $data['houseType'] ?? null,
                'hasAlarm' => $data['hasAlarm'] ?? null,
                'hasAlarmExt' => $data['hasAlarmExt'] ?? null,
                'hasAnimal' => $data['hasAnimal'] ?? null,
                'hasCamera' => $data['hasCamera'] ?? null,
                'blindsSchedule' => $data['blindsSchedule'] ?? null,
                'lightsSchedule' => $data['lightsSchedule'] ?? null,
                'additionalInfo' => $data['additionalInfo'] ?? null,
            ]
        ];

        $otv->setData($jsonData);

        return $otv;
    }

    private function mapEmergencyContact(array $data, int $contactNumber): array
    {
        return [
            'civility' => $data['emergency_civility_' . $contactNumber] ?? null,
            'lastname' => $data['emergency_lastname_' . $contactNumber] ?? null,
            'firstname' => $data['emergency_firstname_' . $contactNumber] ?? null,
            'mobilePhone' => $data['emergency_mobilePhone_' . $contactNumber] ?? null,
            'landlinePhone' => $data['emergency_landlinePhone_' . $contactNumber] ?? null,
            'email' => $data['emergency_email_' . $contactNumber] ?? null,
        ];
    }

    private function validateAndConvertDate($date)
    {
        if (is_array($date) && isset($date['date'])) {
            return new DateTimeImmutable($date['date']);
        } elseif (is_string($date)) {
            return new DateTimeImmutable($date);
        }

        return null;
    }


}