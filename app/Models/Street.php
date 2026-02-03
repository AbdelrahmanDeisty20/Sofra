<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function clients()
    {
        return $this->hasMany(User::class, 'region_id')->where('type', \App\Enums\UserType::CLIENT);
    }

    public function restaurants()
    {
        return $this->hasMany(User::class, 'region_id')->where('type', \App\Enums\UserType::RESTAURANT);
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
