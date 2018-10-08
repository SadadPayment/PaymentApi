<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public function type(){
        return $this->belongsTo('App\Model\TransferType' , 'type_id');
    }
}
