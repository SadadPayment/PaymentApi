<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\Model\User' , 'user_id');

    }
    public function transactionType(){
        return $this->belongsTo('App\Model\TransactionType' , 'transaction_type');
    }
    public function payment(){
        return $this->hasOne('App\Model\Payment');
    }
    public function topUp(){
        return $this->hasOne('App\Model\TopUp');
    }
    public function balanceInquiry(){
        return $this->hasOne('App\Model\BalanceInquiry');
    }
}
