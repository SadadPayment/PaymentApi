<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class TransferResponse extends Model
{
    public function trasfer(){
        return $this->belongsTo('App\Model\Transfer');
    }
    public function response(){
        return $this->belongsTo('App\Model\Response');
    }
}
