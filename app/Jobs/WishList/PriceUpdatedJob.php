<?php

namespace App\Jobs\WishList;


use App\Enums\WishListEnum;
use App\Notifications\WishList\NewPriceNotification;

class PriceUpdatedJob extends BaseJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendNotification(NewPriceNotification::class, WishListEnum::Price);
    }
}
