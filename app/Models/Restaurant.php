<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'minimum_order', 'image', 'delivery_fees', 'pin_code', 'whatsapp', 'status','region_id');

    public function region()
    {
        return $this->belongsTo('App\Models\Street');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function setPasswordAttribute($value)
{
    $this->attributes['password'] = bcrypt($value);
}

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class,'notifiable');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }

}
