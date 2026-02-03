<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function users()
    {
        return $this->hasManyThrough(User::class, Street::class, 'city_id', 'region_id');
    }

    public function regions()
    {
        return $this->hasMany('App\Models\Street');
    }
}
