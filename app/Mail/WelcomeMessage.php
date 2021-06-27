<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Shop;

class WelcomeMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                ->markdown('email.welcome', [
                    'url' => env('APP_URL').'/register?email='.$this->shop->email,
                ]);
    }
}
