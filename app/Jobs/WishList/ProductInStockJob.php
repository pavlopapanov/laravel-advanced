<?php

namespace App\Jobs\WishList;

use App\Enums\WishListEnum;
use App\Notifications\WishList\ProductInStockNotification;

class ProductInStockJob extends BaseJob
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->sendNotification(ProductInStockNotification::class, WishListEnum::InStock);
    }
}
