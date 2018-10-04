<?php

namespace App\Model\Bank;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    //
    public function bank(){
        return $this->belongsTo('App\Model\Bank\Bank');
    }
}
