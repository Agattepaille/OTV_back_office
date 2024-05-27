<?php

namespace App\EventListener;

use App\Entity\OTV;
use App\Services\OTVLimitVerifier;
use App\Services\OTVStatusUpdater;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class OTVListener
{
    private OTVLimitVerifier $otvLimitVerifier;
    private LoggerInterface $logger;
    private OTVStatusUpdater $otvStatusUpdater;

    public function __construct(LoggerInterface $logger, OTVLimitVerifier $otvLimitVerifier, OTVStatusUpdater $otvStatusUpdater)
    {
        $this->otvLimitVerifier = $otvLimitVerifier;
        $this->logger = $logger;
        $this->otvStatusUpdater = $otvStatusUpdater;
    }

    // public function getSubscribedEvents(): array
    // {
    //     return [
    //         Events::postPersist,
    //         Events::postUpdate,
    //     ];
    // }

     public function prePersist(LifecycleEventArgs $args)
    {
        $this->logger->info('prePersist event triggered');

        $this->handleEvent($args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->logger->info('preUpdate event triggered');

        $this->handleEvent($args);
    }

    private function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // We only care about OTV entities
        if (!$entity instanceof OTV) {
            $this->logger->info('Entity is not an OTV');
            return;
        }

        // Mettre à jour le statut des OTV
        $this->otvStatusUpdater->updateStatus($entity);
        $this->logger->info('OTV status updated');

        // Envoyer un e-mail si le résident est au-dessus de la limite
        $this->otvLimitVerifier->sendMailIfOverLimit($entity);
        $this->logger->info('Mail sent if over limit');

       
    }
}
