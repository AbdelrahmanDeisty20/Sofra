<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('facebook_link', 'whatsapp', 'instagram_link', 'email', 'twitter_link', 'youtube_link', 'banks','commission_details');

}
