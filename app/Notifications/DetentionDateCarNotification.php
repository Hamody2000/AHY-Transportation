<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DetentionDateCarNotification extends Notification
{
    use Queueable;

    protected $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    // Only use the 'database' notification channel
    public function via($notifiable)
    {
        return ['database']; // Only use the database channel
    }

    public function toArray($notifiable)
    {
        return [
            'transaction_id' => $this->transaction->id,
            'detention_date_car' => $this->transaction->detention_date_car,
            'message' => 'ميعاد التعتيق للسيارة اليوم للعميل: ' . $this->transaction->client->name,
        ];
    }
}
