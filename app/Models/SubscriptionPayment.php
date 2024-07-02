<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Subscription;


class SubscriptionPayment extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'subscription_id', 'amount', 'total_amount', 'status', 'type', 'payment_path'
    ];

    protected $appends = ['payment_proof_url'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

     public function getPaymentProofUrlAttribute()
    {
        if (!empty($this->attributes['payment_path'])) {
            return asset('storage/' . $this->attributes['payment_path']);
        }

        return null;
    }
}
