<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = array('name', 'details', 'start_time', 'end_time', 'image','restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}
