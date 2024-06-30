<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'subscription_id', 'amount', 'total_amount', 'status', 'type', 'payment_path'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
