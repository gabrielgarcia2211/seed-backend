<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PurchaseConfirmation;

class SendPurchaseEmail implements ShouldQueue  
{  
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;  
  
    protected $user;  
  
    public function __construct(User $user)  
    {  
        $this->user = $user;  
    }  
  
    public function handle()  
    {  
        Mail::to($this->user->email)->send(new PurchaseConfirmation($this->user));
    }  
}