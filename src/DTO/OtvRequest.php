<?php

namespace App\DTO;


class OtvRequest
{
    private $civility;
    private $otherCivility;
    private $lastname;
    private $firstname;
    private $district;
    private $street;
    private $streetNumber;
    private $additionalStreetNumber;
    private $additionalAddressInfo;
    private $mobilePhone;
    private $landlinePhone;
    private $email;
    private $houseType;
    private $hasAlarm;
    private $hasAlarmExt;
    private $hasCamera;
    private $hasAnimal;
    private $blindsSchedule;
    private $lightsSchedule;
    private $car;
    private $additionalInfo;
    private $authorizedPersons;
    private $comments;
    private $startDate;
    private $endDate;
    private $createdAt;
    private $emergencyCivility1;
    private $emergencyLastname1;
    private $emergencyFirstname1;
    private $emergencyMobilePhone1;
    private $emergencyLandlinePhone1;
    private $emergencyEmail1;
    private $emergencyCivility2;
    private $emergencyLastname2;
    private $emergencyFirstname2;
    private $emergencyMobilePhone2;
    private $emergencyLandlinePhone2;
    private $emergencyEmail2;
    private $emergencyCivility3;
    private $emergencyLastname3;
    private $emergencyFirstname3;
    private $emergencyMobilePhone3;
    private $emergencyLandlinePhone3;
    private $emergencyEmail3;
    
    private $latitude;
    private $longitude;

   

    /**
     * Get the value of civility
     */ 
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set the value of civility
     *
     * @return  self
     */ 
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get the value of otherCivility
     */ 
    public function getOtherCivility()
    {
        return $this->otherCivility;
    }

    /**
     * Set the value of otherCivility
     *
     * @return  self
     */ 
    public function setOtherCivility($otherCivility)
    {
        $this->otherCivility = $otherCivility;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of district
     */ 
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set the value of district
     *
     * @return  self
     */ 
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

   

    /**
     * Get the value of street
     */ 
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set the value of street
     *
     * @return  self
     */ 
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get the value of streetNumber
     */ 
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set the value of streetNumber
     *
     * @return  self
     */ 
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get the value of additionalStreetNumber
     */ 
    public function getAdditionalStreetNumber()
    {
        return $this->additionalStreetNumber;
    }

    /**
     * Set the value of additionalStreetNumber
     *
     * @return  self
     */ 
    public function setAdditionalStreetNumber($additionalStreetNumber)
    {
        $this->additionalStreetNumber = $additionalStreetNumber;

        return $this;
    }

    /**
     * Get the value of additionalAddressInfo
     */ 
    public function getAdditionalAddressInfo()
    {
        return $this->additionalAddressInfo;
    }

    /**
     * Set the value of additionalAddressInfo
     *
     * @return  self
     */ 
    public function setAdditionalAddressInfo($additionalAddressInfo)
    {
        $this->additionalAddressInfo = $additionalAddressInfo;

        return $this;
    }

    /**
     * Get the value of mobilePhone
     */ 
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set the value of mobilePhone
     *
     * @return  self
     */ 
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get the value of landlinePhone
     */ 
    public function getLandlinePhone()
    {
        return $this->landlinePhone;
    }

    /**
     * Set the value of landlinePhone
     *
     * @return  self
     */ 
    public function setLandlinePhone($landlinePhone)
    {
        $this->landlinePhone = $landlinePhone;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of houseType
     */ 
    public function getHouseType()
    {
        return $this->houseType;
    }

    /**
     * Set the value of houseType
     *
     * @return  self
     */ 
    public function setHouseType($houseType)
    {
        $this->houseType = $houseType;

        return $this;
    }

    /**
     * Get the value of hasAlarm
     */ 
    public function getHasAlarm()
    {
        return $this->hasAlarm;
    }

    /**
     * Set the value of hasAlarm
     *
     * @return  self
     */ 
    public function setHasAlarm($hasAlarm)
    {
        $this->hasAlarm = $hasAlarm;

        return $this;
    }

    /**
     * Get the value of hasAlarmExt
     */ 
    public function getHasAlarmExt()
    {
        return $this->hasAlarmExt;
    }

    /**
     * Set the value of hasAlarmExt
     *
     * @return  self
     */ 
    public function setHasAlarmExt($hasAlarmExt)
    {
        $this->hasAlarmExt = $hasAlarmExt;

        return $this;
    }

    /**
     * Get the value of hasCamera
     */ 
    public function getHasCamera()
    {
        return $this->hasCamera;
    }

    /**
     * Set the value of hasCamera
     *
     * @return  self
     */ 
    public function setHasCamera($hasCamera)
    {
        $this->hasCamera = $hasCamera;

        return $this;
    }

    /**
     * Get the value of hasAnimal
     */ 
    public function getHasAnimal()
    {
        return $this->hasAnimal;
    }

    /**
     * Set the value of hasAnimal
     *
     * @return  self
     */ 
    public function setHasAnimal($hasAnimal)
    {
        $this->hasAnimal = $hasAnimal;

        return $this;
    }

    /**
     * Get the value of blindsSchedule
     */ 
    public function getBlindsSchedule()
    {
        return $this->blindsSchedule;
    }

    /**
     * Set the value of blindsSchedule
     *
     * @return  self
     */ 
    public function setBlindsSchedule($blindsSchedule)
    {
        $this->blindsSchedule = $blindsSchedule;

        return $this;
    }

    /**
     * Get the value of lightsSchedule
     */ 
    public function getLightsSchedule()
    {
        return $this->lightsSchedule;
    }

    /**
     * Set the value of lightsSchedule
     *
     * @return  self
     */ 
    public function setLightsSchedule($lightsSchedule)
    {
        $this->lightsSchedule = $lightsSchedule;

        return $this;
    }

    /**
     * Get the value of car
     */ 
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set the value of car
     *
     * @return  self
     */ 
    public function setCar($car)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get the value of additionalInfo
     */ 
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * Set the value of additionalInfo
     *
     * @return  self
     */ 
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    /**
     * Get the value of authorizedPersons
     */ 
    public function getAuthorizedPersons()
    {
        return $this->authorizedPersons;
    }

    /**
     * Set the value of authorizedPersons
     *
     * @return  self
     */ 
    public function setAuthorizedPersons($authorizedPersons)
    {
        $this->authorizedPersons = $authorizedPersons;

        return $this;
    }

    /**
     * Get the value of latitude
     */ 
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set the value of latitude
     *
     * @return  self
     */ 
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }


   

    /**
     * Get the value of longitude
     */ 
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set the value of longitude
     *
     * @return  self
     */ 
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of emergencyCivility1
     */ 
    public function getEmergencyCivility1()
    {
        return $this->emergencyCivility1;
    }

    /**
     * Set the value of emergencyCivility1
     *
     * @return  self
     */ 
    public function setEmergencyCivility1($emergencyCivility1)
    {
        $this->emergencyCivility1 = $emergencyCivility1;

        return $this;
    }

    /**
     * Get the value of emergencyLastname1
     */ 
    public function getEmergencyLastname1()
    {
        return $this->emergencyLastname1;
    }

    /**
     * Set the value of emergencyLastname1
     *
     * @return  self
     */ 
    public function setEmergencyLastname1($emergencyLastname1)
    {
        $this->emergencyLastname1 = $emergencyLastname1;

        return $this;
    }

    /**
     * Get the value of emergencyFirstname1
     */ 
    public function getEmergencyFirstname1()
    {
        return $this->emergencyFirstname1;
    }

    /**
     * Set the value of emergencyFirstname1
     *
     * @return  self
     */ 
    public function setEmergencyFirstname1($emergencyFirstname1)
    {
        $this->emergencyFirstname1 = $emergencyFirstname1;

        return $this;
    }

    /**
     * Get the value of emergencyMobilePhone1
     */ 
    public function getEmergencyMobilePhone1()
    {
        return $this->emergencyMobilePhone1;
    }

    /**
     * Set the value of emergencyMobilePhone1
     *
     * @return  self
     */ 
    public function setEmergencyMobilePhone1($emergencyMobilePhone1)
    {
        $this->emergencyMobilePhone1 = $emergencyMobilePhone1;

        return $this;
    }

    /**
     * Get the value of emergencyLandlinePhone1
     */ 
    public function getEmergencyLandlinePhone1()
    {
        return $this->emergencyLandlinePhone1;
    }

    /**
     * Set the value of emergencyLandlinePhone1
     *
     * @return  self
     */ 
    public function setEmergencyLandlinePhone1($emergencyLandlinePhone1)
    {
        $this->emergencyLandlinePhone1 = $emergencyLandlinePhone1;

        return $this;
    }

    /**
     * Get the value of emergencyEmail1
     */ 
    public function getEmergencyEmail1()
    {
        return $this->emergencyEmail1;
    }

    /**
     * Set the value of emergencyEmail1
     *
     * @return  self
     */ 
    public function setEmergencyEmail1($emergencyEmail1)
    {
        $this->emergencyEmail1 = $emergencyEmail1;

        return $this;
    }

    /**
     * Get the value of emergencyCivility2
     */ 
    public function getEmergencyCivility2()
    {
        return $this->emergencyCivility2;
    }

    /**
     * Set the value of emergencyCivility2
     *
     * @return  self
     */ 
    public function setEmergencyCivility2($emergencyCivility2)
    {
        $this->emergencyCivility2 = $emergencyCivility2;

        return $this;
    }

    /**
     * Get the value of emergencyLastname2
     */ 
    public function getEmergencyLastname2()
    {
        return $this->emergencyLastname2;
    }

    /**
     * Set the value of emergencyLastname2
     *
     * @return  self
     */ 
    public function setEmergencyLastname2($emergencyLastname2)
    {
        $this->emergencyLastname2 = $emergencyLastname2;

        return $this;
    }

    /**
     * Get the value of emergencyFirstname2
     */ 
    public function getEmergencyFirstname2()
    {
        return $this->emergencyFirstname2;
    }

    /**
     * Set the value of emergencyFirstname2
     *
     * @return  self
     */ 
    public function setEmergencyFirstname2($emergencyFirstname2)
    {
        $this->emergencyFirstname2 = $emergencyFirstname2;

        return $this;
    }

    /**
     * Get the value of emergencyMobilePhone2
     */ 
    public function getEmergencyMobilePhone2()
    {
        return $this->emergencyMobilePhone2;
    }

    /**
     * Set the value of emergencyMobilePhone2
     *
     * @return  self
     */ 
    public function setEmergencyMobilePhone2($emergencyMobilePhone2)
    {
        $this->emergencyMobilePhone2 = $emergencyMobilePhone2;

        return $this;
    }

    /**
     * Get the value of emergencyLandlinePhone2
     */ 
    public function getEmergencyLandlinePhone2()
    {
        return $this->emergencyLandlinePhone2;
    }

    /**
     * Set the value of emergencyLandlinePhone2
     *
     * @return  self
     */ 
    public function setEmergencyLandlinePhone2($emergencyLandlinePhone2)
    {
        $this->emergencyLandlinePhone2 = $emergencyLandlinePhone2;

        return $this;
    }

    /**
     * Get the value of emergencyEmail2
     */ 
    public function getEmergencyEmail2()
    {
        return $this->emergencyEmail2;
    }

    /**
     * Set the value of emergencyEmail2
     *
     * @return  self
     */ 
    public function setEmergencyEmail2($emergencyEmail2)
    {
        $this->emergencyEmail2 = $emergencyEmail2;

        return $this;
    }

    /**
     * Get the value of emergencyCivility3
     */ 
    public function getEmergencyCivility3()
    {
        return $this->emergencyCivility3;
    }

    /**
     * Set the value of emergencyCivility3
     *
     * @return  self
     */ 
    public function setEmergencyCivility3($emergencyCivility3)
    {
        $this->emergencyCivility3 = $emergencyCivility3;

        return $this;
    }

    /**
     * Get the value of emergencyLastname3
     */ 
    public function getEmergencyLastname3()
    {
        return $this->emergencyLastname3;
    }

    /**
     * Set the value of emergencyLastname3
     *
     * @return  self
     */ 
    public function setEmergencyLastname3($emergencyLastname3)
    {
        $this->emergencyLastname3 = $emergencyLastname3;

        return $this;
    }

    /**
     * Get the value of emergencyFirstname3
     */ 
    public function getEmergencyFirstname3()
    {
        return $this->emergencyFirstname3;
    }

    /**
     * Set the value of emergencyFirstname3
     *
     * @return  self
     */ 
    public function setEmergencyFirstname3($emergencyFirstname3)
    {
        $this->emergencyFirstname3 = $emergencyFirstname3;

        return $this;
    }

    /**
     * Get the value of emergencyMobilePhone3
     */ 
    public function getEmergencyMobilePhone3()
    {
        return $this->emergencyMobilePhone3;
    }

    /**
     * Set the value of emergencyMobilePhone3
     *
     * @return  self
     */ 
    public function setEmergencyMobilePhone3($emergencyMobilePhone3)
    {
        $this->emergencyMobilePhone3 = $emergencyMobilePhone3;

        return $this;
    }

    /**
     * Get the value of emergencyLandlinePhone3
     */ 
    public function getEmergencyLandlinePhone3()
    {
        return $this->emergencyLandlinePhone3;
    }

    /**
     * Set the value of emergencyLandlinePhone3
     *
     * @return  self
     */ 
    public function setEmergencyLandlinePhone3($emergencyLandlinePhone3)
    {
        $this->emergencyLandlinePhone3 = $emergencyLandlinePhone3;

        return $this;
    }

    /**
     * Get the value of emergencyEmail3
     */ 
    public function getEmergencyEmail3()
    {
        return $this->emergencyEmail3;
    }

    /**
     * Set the value of emergencyEmail3
     *
     * @return  self
     */ 
    public function setEmergencyEmail3($emergencyEmail3)
    {
        $this->emergencyEmail3 = $emergencyEmail3;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of comments
     */ 
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the value of comments
     *
     * @return  self
     */ 
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }
}

