<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $twilio;

    public function __construct()
    {
        // Log Twilio credentials for debugging
        Log::info('Twilio SID: ' . env('TWILIO_SID'));
        Log::info('Twilio Auth Token: ' . env('TWILIO_AUTH_TOKEN'));

        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    /**
     * Send SMS using Twilio.
     *
     * @param string $no_hp The recipient's phone number
     * @param string $message The message to be sent
     * @return void
     */
    public function sendSms(string $no_hp, string $message)
    {
        try {
            Log::info('Attempting to send SMS to ' . $no_hp);

            $response = $this->twilio->messages->create($no_hp, [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message,
            ]);

            // Log message SID
            Log::info('Twilio message SID', [
                'sid' => $response->sid,
            ]);

            // Log complete Twilio response
            Log::info('Twilio response: ' . json_encode($response));
            
        } catch (\Exception $e) {
            Log::error('Error sending SMS via Twilio: ' . $e->getMessage());
            throw $e;
        }
    }
}
