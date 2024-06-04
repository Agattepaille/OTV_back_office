<?php
namespace App\EventListener;

use App\Entity\OTV;
use App\Services\OTVLimitVerifier;
use App\Services\OTVStatusUpdater;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class OTVListener
{
    private OTVLimitVerifier $otvLimitVerifier;
    private LoggerInterface $logger;
    private OTVStatusUpdater $otvStatusUpdater;
    private EntityManagerInterface $entityManager;

    public function __construct(
        LoggerInterface $logger, 
        OTVLimitVerifier $otvLimitVerifier, 
        OTVStatusUpdater $otvStatusUpdater,
        EntityManagerInterface $entityManager
        )
    {
        $this->otvLimitVerifier = $otvLimitVerifier;
        $this->logger = $logger;
        $this->otvStatusUpdater = $otvStatusUpdater;
        $this->entityManager = $entityManager;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->logger->info('prePersist event triggered');
        $this->handleEvent($args);
    }

    private function handleEvent(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On ne traite que les OTV
        if (!$entity instanceof OTV) {
            $this->logger->info('Entity is not an OTV');
            return;
        }

        // Envoyer un e-mail si le résident est au-dessus de la limite
        $this->otvLimitVerifier->sendMailIfOverLimit($entity);
        $this->logger->info('Mail sent if over limit');
    }
}