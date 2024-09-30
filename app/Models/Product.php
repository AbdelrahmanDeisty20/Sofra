<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array(
        'name',
        'details',
        'price',
        'offer_price',
        'ready',
        'restaurant_id',
        'image'
);

    public function order()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}
