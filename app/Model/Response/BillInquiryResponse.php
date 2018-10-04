<?php

namespace App\Model\Response;

use Illuminate\Database\Eloquent\Model;

class BillInquiryResponse extends Model
{
    //
    public function billInquiry(){
        return $this->belongsTo('App\Model\BillInquiry');
    }
}
