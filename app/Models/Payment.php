<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'amount', 'total_amount', 'status', 'type', 'payment_path'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected $appends = ['payment_proof_url'];

    public function getPaymentProofUrlAttribute()
    {
        // Ensure that 'payment_path' is set and not empty
        if (!empty($this->attributes['receipt_path'])) {
            return asset('storage/' . $this->attributes['receipt_path']);
        }
    
        return null;
    }
}
