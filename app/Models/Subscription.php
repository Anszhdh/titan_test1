<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionItem;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Models\Recommendation;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'price',
        'recommendation_id',
        'duration',
        'trial_days',
        'start_date',
        'end_date',
        'status',
        'payment_ver',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
    public function subscriptionItem()
    {
        return $this->hasMany(SubscriptionItem::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }

    public function subscriptionAnswers()
    {
        return $this->hasMany(SubscriptionAnswer::class);
    }
    public function shipping()
    {
        return $this->hasOne(SubscriptionShipping::class);
    }
}
