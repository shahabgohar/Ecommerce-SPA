<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table = 'images';
    public function item()
    {
        return $this->belongsTo('App\Item','User');
    }
}
