<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, Notifiable;

    // Indicate that the ID column is a UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [ 
        'type',
        'notifiable',
        'data',
        'read_at',
    ];
    // Define any relationships or additional methods here
}