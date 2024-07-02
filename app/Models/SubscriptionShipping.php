<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionShipping extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'subscription_id', 'shipping_type', 'tracking_number',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
