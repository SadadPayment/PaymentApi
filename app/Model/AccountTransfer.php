<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccountTransfer extends Model
{
    //
    public function transfer(){
        return $this->belongsTo('App\Model\Transfer');
    }
}
