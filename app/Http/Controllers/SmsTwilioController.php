<?php

namespace App\Http\Controllers;

use App\Entities\DataCalonNasabah;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsTwilioController extends Controller
{
    public function sendSms($id)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilio = new Client($sid, $token);

        $dataCalonNasabah = DataCalonNasabah::find($id);

        if (!$dataCalonNasabah) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $phoneNumber = $dataCalonNasabah->no_hp;
        $formattedPhoneNumber = '+62' . substr($phoneNumber, 1); // Adjust this based on your phone number format

        $to = $formattedPhoneNumber;
        $from = env('TWILIO_PHONE_NUMBER');
        $body = 'Selamat akun anda sudah berhasil dibuat';

        try {
            $twilio->messages->create($to, [
                'from' => $from,
                'body' => $body,
            ]);
            return response()->json(['message' => 'Message sent']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
