<?php

namespace App\Services;

use App\Entity\OTV;
use Psr\Log\LoggerInterface;
use App\Repository\OTVRepository;
use Symfony\Component\Mime\Address;

class OTVLimitVerifier
{
    private OTVRepository $oTVRepository;
    private LoggerInterface $logger;
    private SendMail $sendMail;
    private string $projectDir;

    public function __construct(OTVRepository $oTVRepository, LoggerInterface $logger, SendMail $sendMail, string $projectDir)
    {
        $this->oTVRepository = $oTVRepository;
        $this->logger = $logger;
        $this->sendMail = $sendMail;
        $this->projectDir = $projectDir;
    }

    public function sendMailIfOverLimit(OTV $otv)
    {
        $resident = $otv->getResidents();
        $residentId = $resident->getId();

        // Check if resident is over the limitation
        if ($this->isOverLimitation($residentId)) {
            $this->logger->info('Resident ID ' . $residentId . ' is over the OTV limit');

            $logoPolice = $this->sendMail->imageToBase64($this->projectDir . '/public/assets/images/Logo_Police_Municipale__France_.webp');
            $from = new Address('noreply@marcq-en-baroeul');
            $toUser = 'police@municipale.fr';
            $subject = 'Opération Tranquillité Vacances - notification';
            $template = 'notificationResidentOverLimit';
            $context = [
                'lastname' => $resident->getLastname(),
                'firstname' => $resident->getFirstname(),
                'mobilePhone' => $resident->getMobilePhone(),
                'landlinePhone' => $resident->getLandlinePhone(),
                'courriel' => $resident->getEmail(),
                'logoPolice' => $logoPolice,
                'street' => $resident->getStreet(),
                'streetNumber' => $resident->getStreetNumber(),
                'additionalStreetNumber' => $resident->getAdditionalStreetNumber(),
                'additionalAddressInfo' => $resident->getAdditionalAddressInfo(),
                'district' => $resident->getDistricts()->getName(), 
                'OTVs' => $resident->getOTVs(),
            ];

            $this->sendMail->send(
                $from,
                $toUser,
                $subject,
                $template,
                $context
            );
            $this->logger->info('Email sent to ' . $toUser);
        } else {
            $this->logger->info('Resident ID ' . $residentId . ' is not over the OTV limit');
        }
    }

    private function isOverLimitation($residentId): bool
    {
        $OTVs = $this->oTVRepository->findByResidentId($residentId);
        $OTVCount = count($OTVs);
        if ($OTVCount >= 3) {
            return true;
        }
        return false;
    }
}
