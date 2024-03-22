<?php

namespace App\Broadcasting;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class SmsChannel
{
    /**
     * Authenticate the user's access to the channel.
     * @throws GuzzleException
     * @throws Exception
     */
    public function send($notifiable, $notification): void
    {
        $message = $notification->toSms($notifiable);
        $provider = Config::get('sms.default');
        $url = Config::get('sms.providers.' . $provider . '.url');
        $response = Http::retry(3)->post($url, [
            'message' => $message,
            'to' => $notifiable->phone,
        ]);
        if ($response->status() !== 200) {
            throw new Exception('Failed to send SMS');
        }else{
            info( 'SMS sent successfully');
        }
    }
}
