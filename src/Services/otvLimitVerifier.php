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
        try {
            $resident = $otv->getResidents();
            $address = $otv->getAddress();

            if (!$resident || !$address) {
                $this->logger->info('Resident or address does not exist');
                return;
            }

            $residentId = $resident->getId();
            $addressId = $address->getId();

            // Check if resident or address is over the limitation
            if ($this->isOverLimitation($residentId, 'resident') || $this->isOverLimitation($addressId, 'address')) {
                $this->logger->info('Resident ID ' . $residentId . ' or Address ID ' . $addressId . ' is over the OTV limit');

                $logoPolice = $this->sendMail->imageToBase64($this->projectDir . '/public/assets/images/Logo_Police_Municipale__France_.webp');
                $from = new Address('noreply@marcq-en-baroeul');
                $toUser = 'noreply@marcq-en-baroeul.fr';
                $subject = 'Opération Tranquillité Vacances - notification';
                $template = 'notificationResidentOverLimit';
                $context = [
                    'lastname' => $resident->getLastname(),
                    'firstname' => $resident->getFirstname(),
                    'mobilePhone' => $otv->getMobilePhone(),
                    'landlinePhone' => $otv->getLandlinePhone(),
                    'courriel' => $otv->getEmail(),
                    'logoPolice' => $logoPolice,
                    'street' => $address->getStreet(),
                    'streetNumber' => $address->getStreetNumber(),
                    'additionalStreetNumber' => $address->getAdditionnalStreetNumber(),
                    'additionalAddressInfo' => $address->getAdditionalAddressInfo(),
                    'district' => $otv->getDistrict()->getName(),
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
                $this->logger->info('Resident ID ' . $residentId . ' and Address ID ' . $addressId . ' are not over the OTV limit');
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while sending email: ' . $e->getMessage());
        }
    }

    private function isOverLimitation($id, $type): bool
    {
        $criteria = ($type === 'resident') ? ['residents' => $id, 'status' => 'ongoing'] : ['address' => $id, 'status' => 'ongoing'];
        $OTVs = $this->oTVRepository->findBy($criteria);

        return count($OTVs) >= 3;
    }
}
