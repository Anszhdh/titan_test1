<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPersonInformation extends Model
{
    use HasFactory;

    protected $table = 'contact_person_information';

    protected $fillable = [
        'business_id',
        'name',
        'position',
        'email',
        'tel_no',
        'mobile_phone',
    ];

    public function businessInformation()
    {
        return $this->belongsTo(BusinessInformation::class, 'business_id');
    }
}
