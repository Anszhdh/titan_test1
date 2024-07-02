<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Carbon\Carbon;

class UpdateSubscriptionStatus extends Command
{
    protected $signature = 'subscriptions:update-status';
    protected $description = 'Update subscription statuses to inactive if they have passed their end date.';

    public function handle()
    {
        // Get subscriptions that are still active and have passed their end date
        $subscriptions = Subscription::where('status', 'Active')
            ->whereDate('end_date', '<', Carbon::today())
            ->get();

        // Update each subscription status to 'Inactive'
        foreach ($subscriptions as $subscription) {
            $subscription->update(['status' => 'Inactive']);
        }

        $this->info('Subscription statuses updated successfully.');
    }
}
