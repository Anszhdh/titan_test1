<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class AdminNewSubscriptionNotification extends Notification
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
            ->line('A new subscription #'. $this->subscription->id . ' has been created.')
            ->action('View Subscription', url('/admin/subscription-centre'))
            ->line('Please review the new subscription.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'A new subscription #'. $this->subscription->id . ' has been created.',
            'subscription_id' => $this->subscription->id,
             'type' => 'admin',
        ];
    }
}