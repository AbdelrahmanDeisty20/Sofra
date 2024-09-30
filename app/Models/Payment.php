<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = array('pay', 'date', 'details','restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}
