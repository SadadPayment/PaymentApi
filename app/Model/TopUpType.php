<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TopUpType extends Model
{
    //
    public function payment(){
        return $this->belongsTo('App\Model\payment');
    }
}
