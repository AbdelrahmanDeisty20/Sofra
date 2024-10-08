<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{

    protected $table = 'regions';
    public $timestamps = true;
    protected $fillable = array('name','city_id');

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

}
