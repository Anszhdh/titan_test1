<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\CustomerAddress;
use App\Models\Cart;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'birthday',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // User.php (User model)

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function address()
    {
        return $this->hasOne(CustomerAddress::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class); // Ensure Cart model is correctly referenced
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function businessInformation()
    {
        return $this->hasOne(BusinessInformation::class);
    }


    public function getRecentUsers()
{
    $recentUsers = User::where('role', 0) // Customers
        ->orWhere('role', 2) // Dealers
        ->where('created_at', '>=', now()->subDays(7)) // Last 7 days
        ->get();

    return response()->json($recentUsers);
}
}