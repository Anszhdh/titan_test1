<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class AdminCancelSubscriptionNotification extends Notification
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
        ->line('Your subscription' . $this->subscription->id . 'has been canceled.')
        ->action('View Subscription', url('/subscriptions'))
        ->line('We are sorry to see you go.');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your subscription id:'  . $this->subscription->id . ' has been canceled, we are sorry.',
            'subscription_id' => $this->subscription->id,
            'type' => 'user',
        ];
    }
}