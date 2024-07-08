<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Subscription;

class UserNewSubscriptionNotification extends Notification
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
            ->line('Your subscription' . $this->subscription->id . 'has been successfully created.')
            ->action('View Subscription', url('/subscriptions'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your subscription' . $this->subscription->id . 'has been successfully created.',
            'subscription_id' => $this->subscription->id,
            'type' => 'user' // Type of notification
        ];
    }
}