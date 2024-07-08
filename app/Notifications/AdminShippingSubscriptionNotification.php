<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;
use App\Models\SbscriptionShipping;

class AdminShippingSubscriptionNotification extends Notification
{
    use Queueable;

    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your subscription #'. $this->subscription->id . ' has been shipped.')
            ->action('View Subscription', url('/subscriptions'))
            ->line('Please review the new subscription.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your subscription #'. $this->subscription->id . ' has been shipped.',
            'subscription_id' => $this->subscription->id,
             'type' => 'user',
        ];
    }
}
