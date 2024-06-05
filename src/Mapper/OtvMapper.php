<?php

namespace App\Mapper;

use App\Entity\OTV;
use App\DTO\OtvRequest;

class OtvMapper
{
    private function booleanToYesNo(bool $value): string
    {
        if ($value === null) {
            return '';
        }
        
        return $value ? 'Oui' : 'Non';
    }

    private function yesNoToBoolean(string $value): bool
    {
        return strtolower($value) === 'oui';
    }

    public function mapToOtvRequest(OTV $OTV, OtvRequest $OtvRequest): OtvRequest
    {
        $OtvRequest->setCivility($OTV->getResidents()->getCivility());
        $OtvRequest->setLastname($OTV->getResidents()->getLastname());
        $OtvRequest->setFirstname($OTV->getResidents()->getFirstname());
        $OtvRequest->setStreet($OTV->getAddress()->getStreet());
        $OtvRequest->setStreetNumber($OTV->getAddress()->getStreetNumber());
        $OtvRequest->setAdditionalStreetNumber($OTV->getAddress()->getAdditionnalStreetNumber());
        $OtvRequest->setAdditionalAddressInfo($OTV->getAddress()->getAdditionalAddressInfo());
        $OtvRequest->setDistrict($OTV->getDistrict()->getName());
        $OtvRequest->setStartDate($OTV->getStartDate());
        $OtvRequest->setEndDate($OTV->getEndDate());
        $OtvRequest->setEmail($OTV->getEmail());
        $OtvRequest->setMobilePhone($OTV->getMobilePhone());
        $OtvRequest->setLandlinePhone($OTV->getLandlinePhone());
        $OtvRequest->setComments($OTV->getComments());

        $data = $OTV->getData();
        $houseType = $data['otvInfo']['houseType'];
        $OtvRequest->setHouseType($houseType);
        $OtvRequest->setHasAlarm($this->yesNoToBoolean($data['otvInfo']['hasAlarm']));
        $OtvRequest->setHasAlarmExt($this->yesNoToBoolean($data['otvInfo']['hasAlarmExt']));
        $OtvRequest->setHasAnimal($this->yesNoToBoolean($data['otvInfo']['hasAnimal']));
        $OtvRequest->setHasCamera($this->yesNoToBoolean($data['otvInfo']['hasCamera']));
        $OtvRequest->setBlindsSchedule($data['otvInfo']['blindsSchedule']);
        $OtvRequest->setLightsSchedule($data['otvInfo']['lightsSchedule']);
        $OtvRequest->setAdditionalInfo($data['otvInfo']['additionalInfo']);
        $OtvRequest->setAuthorizedPersons($data['authorizedPersons']);
        $OtvRequest->setCar($data['car']);
        $OtvRequest->setEmergencyCivility1($data['emergencyContact1']['civility']);
        $OtvRequest->setEmergencyLastname1($data['emergencyContact1']['lastname']);
        $OtvRequest->setEmergencyFirstname1($data['emergencyContact1']['firstname']);
        $OtvRequest->setEmergencyMobilePhone1($data['emergencyContact1']['mobilePhone']);
        $OtvRequest->setEmergencyLandlinePhone1($data['emergencyContact1']['landlinePhone']);
        $OtvRequest->setEmergencyEmail1($data['emergencyContact1']['email']);
        $OtvRequest->setEmergencyCivility2($data['emergencyContact2']['civility']);
        $OtvRequest->setEmergencyLastname2($data['emergencyContact2']['lastname']);
        $OtvRequest->setEmergencyFirstname2($data['emergencyContact2']['firstname']);
        $OtvRequest->setEmergencyMobilePhone2($data['emergencyContact2']['mobilePhone']);
        $OtvRequest->setEmergencyLandlinePhone2($data['emergencyContact2']['landlinePhone']);
        $OtvRequest->setEmergencyEmail2($data['emergencyContact2']['email']);
        $OtvRequest->setEmergencyCivility3($data['emergencyContact3']['civility']);
        $OtvRequest->setEmergencyLastname3($data['emergencyContact3']['lastname']);
        $OtvRequest->setEmergencyFirstname3($data['emergencyContact3']['firstname']);
        $OtvRequest->setEmergencyMobilePhone3($data['emergencyContact3']['mobilePhone']);
        $OtvRequest->setEmergencyLandlinePhone3($data['emergencyContact3']['landlinePhone']);
        $OtvRequest->setEmergencyEmail3($data['emergencyContact3']['email']);

        return $OtvRequest;
    }

    public function mapToOtv(OTV $OTV, OtvRequest $OtvRequest): OTV
    {
        $OTV->getResidents()->setCivility($OtvRequest->getCivility());
        $OTV->getResidents()->setLastname($OtvRequest->getLastname());
        $OTV->getResidents()->setFirstname($OtvRequest->getFirstname());
        $OTV->getAddress()->setStreet($OtvRequest->getStreet());
        $OTV->getAddress()->setStreetNumber($OtvRequest->getStreetNumber());
        $OTV->getAddress()->setAdditionnalStreetNumber($OtvRequest->getAdditionalStreetNumber());
        $OTV->getAddress()->setAdditionalAddressInfo($OtvRequest->getAdditionalAddressInfo());
        $OTV->getDistrict()->setName($OtvRequest->getDistrict());
        $OTV->setStartDate($OtvRequest->getStartDate());
        $OTV->setEndDate($OtvRequest->getEndDate());
        $OTV->setEmail($OtvRequest->getEmail());
        $OTV->setMobilePhone($OtvRequest->getMobilePhone());
        $OTV->setLandlinePhone($OtvRequest->getLandlinePhone());
        $OTV->setComments($OtvRequest->getComments());

        $data = $OTV->getData();
        $data['otvInfo']['houseType'] = $OtvRequest->getHouseType();
        $data['otvInfo']['hasAlarm'] = $OtvRequest->getHasAlarm();
        $data['otvInfo']['hasAlarmExt'] =$OtvRequest->getHasAlarmExt();
        $data['otvInfo']['hasAnimal'] = $OtvRequest->getHasAnimal();
        $data['otvInfo']['hasCamera'] = $OtvRequest->getHasCamera();
        $data['otvInfo']['blindsSchedule'] = $OtvRequest->getBlindsSchedule();
        $data['otvInfo']['lightsSchedule'] = $OtvRequest->getLightsSchedule();
        $data['otvInfo']['additionalInfo'] = $OtvRequest->getAdditionalInfo();
        $data['authorizedPersons'] = $OtvRequest->getAuthorizedPersons();
        $data['car'] = $OtvRequest->getCar();
        $data['emergencyContact1']['civility'] = $OtvRequest->getEmergencyCivility1();
        $data['emergencyContact1']['lastname'] = $OtvRequest->getEmergencyLastname1();
        $data['emergencyContact1']['firstname'] = $OtvRequest->getEmergencyFirstname1();
        $data['emergencyContact1']['mobilePhone'] = $OtvRequest->getEmergencyMobilePhone1();
        $data['emergencyContact1']['landlinePhone'] = $OtvRequest->getEmergencyLandlinePhone1();
        $data['emergencyContact1']['email'] = $OtvRequest->getEmergencyEmail1();
        $data['emergencyContact2']['civility'] = $OtvRequest->getEmergencyCivility2();
        $data['emergencyContact2']['lastname'] = $OtvRequest->getEmergencyLastname2();
        $data['emergencyContact2']['firstname'] = $OtvRequest->getEmergencyFirstname2();
        $data['emergencyContact2']['mobilePhone'] = $OtvRequest->getEmergencyMobilePhone2();
        $data['emergencyContact2']['landlinePhone'] = $OtvRequest->getEmergencyLandlinePhone2();
        $data['emergencyContact2']['email'] = $OtvRequest->getEmergencyEmail2();
        $data['emergencyContact3']['civility'] = $OtvRequest->getEmergencyCivility3();
        $data['emergencyContact3']['lastname'] = $OtvRequest->getEmergencyLastname3();
        $data['emergencyContact3']['firstname'] = $OtvRequest->getEmergencyFirstname3();
        $data['emergencyContact3']['mobilePhone'] = $OtvRequest->getEmergencyMobilePhone3();
        $data['emergencyContact3']['landlinePhone'] = $OtvRequest->getEmergencyLandlinePhone3();
        $data['emergencyContact3']['email'] = $OtvRequest->getEmergencyEmail3();

        $OTV->setData($data);

        return $OTV;
    }
}
