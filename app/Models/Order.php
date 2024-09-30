<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('state','net', 'delivery_charge', 'commission', 'address', 'payment_method','client_id','restaurant_id','note','total_price');

    public function client()
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price','quantity','note');
    }

}
