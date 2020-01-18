<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function categories(){
        return $this->belongsTo('App\Categories','id');
    }
    public function checkouts(){
        return $this->hasMany('App\checkout','ProductId');
    }
    public function sales(){
        return $this->hasMany('App\sale','ItemId');
    }

    public function owner(){
        return $this->belongsTo('App\Models\User','owner');
    }
    public function images()
    {
        return $this->hasMany('App\image','User');
    }
}
