<?php
namespace App\Services;

use App\Entity\OTV;
use Doctrine\ORM\EntityManagerInterface;

class OTVStatusUpdater
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function updateStatus(OTV $otv)
    {
        $now = new \DateTimeImmutable();
        $endDate = $otv->getEndDate();
        $startDate = $otv->getStartDate();

        if ($endDate < $now) {
            $otv->setStatus("completed");
        } elseif ($startDate->format('Y-m-d') === $now->format('Y-m-d')) {
            $otv->setStatus("ongoing");
        }
        $this->entityManager->persist($otv);
        $this->entityManager->flush();
    }
}
