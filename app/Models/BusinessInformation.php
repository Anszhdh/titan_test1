<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInformation extends Model
{
    use HasFactory;

    protected $table = 'business_information';

    protected $fillable = [
        'user_id',
        'business_name',
        'business_registration_no',
        'name_of_owner',
        'address',
        'delivery_address',
        'tel_no',
        'social_media',
        'website',
        'email',
        'year_started',
        'business_structure',
        'number_of_employees',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactPersonInformation()
    {
        return $this->hasMany(ContactPersonInformation::class, 'business_id');
    }
}

