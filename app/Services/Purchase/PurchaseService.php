<?php

namespace App\Services\Purchase;

use App\Models\User;
use App\Jobs\SendPurchaseEmail;

class PurchaseService
{
    public function handlePurchase($data): void
    {
        $user = User::where('email', $data['email'])->first();
        dispatch(new SendPurchaseEmail($user));
    }
}
