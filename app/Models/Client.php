<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Model
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'pin_code', 'image', 'status','region_id');

    public function city()
    {
        return $this->belongsToMany('App\Models\City');
    }
    public function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}


    public function regions()
    {
        return $this->belongsTo(Street::class,'region_id');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class,'notifiable');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\Comment');
    }

}
