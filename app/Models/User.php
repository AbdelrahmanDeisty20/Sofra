<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // use HasFactory, Notifiable;
    use HasFactory, Notifiable, HasApiTokens;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'phone',
        'region_id',
        'pin_code',
        'image',
        'status',
        'minimum_order',
        'delivery_fees',
        'whatsapp',
        'api_token'
    ];

    // protected $append=['roles_list'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
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
            'type' => \App\Enums\UserType::class,
            'status' => 'boolean',
            'minimum_order' => 'decimal:2',
            'delivery_fees' => 'decimal:2',
        ];
    }

    public function region()
    {
        return $this->belongsTo(Street::class, 'region_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, $this->type === \App\Enums\UserType::CLIENT ? 'client_id' : 'restaurant_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'restaurant_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'restaurant_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, $this->type === \App\Enums\UserType::CLIENT ? 'client_id' : 'restaurant_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'restaurant_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant', 'restaurant_id', 'category_id');
    }
}
