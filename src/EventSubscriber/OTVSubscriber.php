<?php

namespace App\EventSubscriber;

use App\Entity\OTV;
use Doctrine\ORM\Events;
use App\Services\SendMail;
use App\Services\otvLimitVerifier;
use Symfony\Component\Mime\Address;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class OTVSubscriber implements EventSubscriber
{
    private $otvLimitVerifier;
    private $sendMail;
    private $projectDir;

    public function __construct(otvLimitVerifier $otvLimitVerifier, SendMail $sendMail, string $projectDir)
    {
        $this->otvLimitVerifier = $otvLimitVerifier;
        $this->sendMail = $sendMail;
        $this->projectDir = $projectDir;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->handleEvent($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->handleEvent($args);
    }

    private function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // We only care about OTV entities
        if (!$entity instanceof OTV) {
            return;
        }

        $resident = $entity->getResidents();

        // Check if resident is over the limitation
        if (!$this->otvLimitVerifier->isOverLimitation($resident)) {

            $logoPolice = $this->sendMail->imageToBase64($this->projectDir . '/public/assets/images/Logo_Police_Municipale__France_.webp');
            $from = new Address('noreply@marcq-en-baroeul');
            $toUser = 'police@municipale.fr';
            $subject = 'Opération Tranquillité Vacances - notification';
            $template = 'notification_otv';
            $context = [
                'lastname' => $resident->getLastname(),
                'firstname' => $resident->getFirstname(),
                'logoPolice' => $logoPolice,
                'streetNumber' => $resident->getStreetNumber(),
                'additionalStreetNumber' => $resident->getAdditionalStreetNumber(),
                'additionalAddressInfo' => $resident->getAdditionalAddressInfo(),
                'district' => $resident->getDistricts()->getName(),
                'OTVs' => $resident->getOTVs(),
            ];

            $this->sendMail->send(
                // Envoi de l'email de notification
                    $from,
                    $toUser,
                    $subject,
                    $template,
                    $context
                );
        }
    }
}
