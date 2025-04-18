<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $secret;
    protected $account;

    public function __construct()
    {
        $this->secret = config('services.whapify.secret');
        $this->account = config('services.whapify.account');
    }

    /**
     * Kirim pesan WhatsApp via Whapify
     */
    public function sendMessage(string $recipient, string $message): bool
    {
        try {
            $response = Http::asForm()->post('https://whapify.id/api/send/whatsapp', [
                'secret' => $this->secret,
                'account' => $this->account,
                'recipient' => $recipient,
                'type' => 'text',
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent to ' . $recipient);
                return true;
            } else {
                Log::error('WhatsApp sending failed: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp exception: ' . $e->getMessage());
            return false;
        }
    }
}
