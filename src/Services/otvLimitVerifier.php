<?php


namespace App\Services;


use App\Entity\Residents;
use App\Repository\OTVRepository;

class otvLimitVerifier {

    private $oTVRepository;

    public function __construct(OTVRepository $oTVRepository)
    {
        $this->oTVRepository = $oTVRepository;
    }

 public function isOverLimitation(Residents $resident): bool
 {
     $OTVs = $this->oTVRepository->findBy(['resident' => $resident]);
     $OTVCount = count($OTVs);
     if ($OTVCount >= 3) {
         return true;
     }
     return false;
 }

}