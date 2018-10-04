<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BillInquiry extends Model
{
    //
    public function transaction(){
        return $this->belongsTo('App\Model\Transaction');
    }
    public function merchant(){
        return $this->belongsTo('App\Model\Merchant\Merchant');
    }
}
