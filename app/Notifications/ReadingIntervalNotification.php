<?php

namespace App\Notifications;

use App\Broadcasting\SmsChannel;
use Illuminate\Notifications\Notification;

class ReadingIntervalNotification extends Notification
{
    public function via($notifiable): array
    {
        return [SmsChannel::class];
    }

    public function toSms($notifiable): string
    {
        return "Thank you for submitting your reading interval!";
    }
}
