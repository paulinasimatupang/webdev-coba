<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $detail_message;

    public function __construct($detail_message)
    {
        $this->detail_message = $detail_message;
    }

    public function build()
    {
        return $this->from($this->detail_message['sender'])
                    ->subject($this->detail_message['subject'])
                    ->markdown('apps.merchants.send-email');
    }
}
