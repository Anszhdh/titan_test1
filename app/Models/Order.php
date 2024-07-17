<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    public function index()
    {
        $orders = Order::with(['user', 'payment'])->get();

        return Inertia::render('Admin/OrderCentre', [
            'orders' => $orders,
        ]);
    }
    protected $fillable = [
        'user_id', 'price', 'total_price', 'status', 'receipt_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function address()
    {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}