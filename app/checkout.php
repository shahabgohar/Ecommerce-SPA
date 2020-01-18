<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class checkout extends Model
{
    protected $table = 'checkout';

    public function item(){
        return $this->belongsTo('App\Item','ProductId');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','UserId');
    }

}
