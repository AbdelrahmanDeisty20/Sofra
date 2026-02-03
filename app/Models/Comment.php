<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $timestamps = true;
    protected $fillable = array('comment', 'rate', 'client_id', 'restaurant_id');

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(User::class, 'restaurant_id');
    }
}
