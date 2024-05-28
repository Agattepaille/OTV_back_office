<?php

namespace App\Services;

use App\Entity\OTV;

class OTVStatusUpdater
{
    public function updateStatus(OTV $otv)
    {
        $now = new \DateTime();
        $endDate = $otv->getEndDate();

        if ($endDate < $now) {
            $otv->setPending(false);
        }
    }
}