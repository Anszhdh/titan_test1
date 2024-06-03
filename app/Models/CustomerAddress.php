<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class CustomerAddress extends Model
{
    protected $fillable = [
        'address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'phone_number', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}