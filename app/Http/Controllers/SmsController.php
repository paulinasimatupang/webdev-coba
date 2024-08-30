<?php

namespace App\Http\Controllers;

use App\Services\SmsService;
use App\Entities\DataCalonNasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Send SMS to a customer.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Incoming SMS request: ', $request->all());

        // Validate input
        $request->validate([
            'no_identitas' => 'required|string',
            'message' => 'required|string',
        ]);

        // Find the customer by no_identitas
        $nasabah = DataCalonNasabah::where('no_identitas', $request->input('no_identitas'))->first();

        // Check if the customer exists and has a phone number
        if ($nasabah && $nasabah->no_hp) {
            try {
                // Convert phone number to international format
                $no_hp_international = $this->convertToInternationalFormat($nasabah->no_hp);

                // Log the phone number and message before sending
                Log::info('Sending SMS to ' . $no_hp_international . ' with message: ' . $request->input('message'));

                // Send SMS using Twilio
                $this->smsService->sendSms($no_hp_international, $request->input('message'));

                // Log successful SMS send
                Log::info('SMS sent successfully to ' . $no_hp_international);

                return response()->json(['message' => 'SMS sent successfully']);
            } catch (\Exception $e) {
                // Log the error details
                Log::error('Error sending SMS: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to send SMS'], 500);
            }
        } else {
            // Log case where customer is not found or no_hp is not available
            Log::error('Nasabah not found or no_hp not available for no_identitas: ' . $request->input('no_identitas'));
            return response()->json(['error' => 'Customer not found or no_hp not available'], 404);
        }
    }

    /**
     * Convert phone number to international format.
     *
     * @param string $no_hp The phone number
     * @return string
     */
    private function convertToInternationalFormat(string $no_hp): string
    {
        // Assuming the country code is +62 for Indonesia
        return '+62' . ltrim($no_hp, '0');
    }
}
