<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionAnswer extends Model
{
    protected $fillable = [
        'subscription_id',
        'question_id',
        'answer',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
